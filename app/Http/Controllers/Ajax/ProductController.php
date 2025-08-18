<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\ProductServiceInterface  as ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface  as ProductRepository;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface  as ProductVariantRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface  as PromotionRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface  as AttributeRepository;
use App\Models\Language;
use Cart;


class ProductController extends Controller
{
    protected $productService;
    protected $productRepository;
    protected $productVariantRepository;
    protected $promotionRepository;
    protected $attributeRepository;
    protected $language;

    public function __construct(
        ProductRepository $productRepository,
        ProductVariantRepository $productVariantRepository,
        PromotionRepository $promotionRepository,
        AttributeRepository $attributeRepository,
        ProductService $productService,
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
        $this->promotionRepository = $promotionRepository;
        $this->attributeRepository = $attributeRepository;
        $this->productService = $productService;
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function loadProductPromotion(Request $request)
    {
        $get = $request->input();
        $loadClass = loadClass($get['model']);


        if ($get['model'] == 'Product') {
            $condition = [
                ['tb2.language_id', '=', $this->language]
            ];
            if (isset($get['keyword']) && $get['keyword'] != '') {
                $keywordCondition = ['tb2.name', 'LIKE', '%' . $get['keyword'] . '%'];
                array_push($condition, $keywordCondition);
            }
            $objects = $loadClass->findProductForPromotion($condition);
        } else if ($get['model'] == 'ProductCatalogue') {

            $conditionArray['keyword'] = ($get['keyword']) ?? null;
            $conditionArray['where'] = [
                ['tb2.language_id', '=', $this->language]
            ];

            $objects = $loadClass->pagination(
                [
                    'product_catalogues.id',
                    'tb2.name',
                ],
                $conditionArray,
                20,
                ['path' => 'product.catalogue.index'],
                ['product_catalogues.id', 'DESC'],
                [
                    ['product_catalogue_language as tb2', 'tb2.product_catalogue_id', '=', 'product_catalogues.id']
                ],
                []
            );
        }

        return response()->json([
            'model' => ($get['model']) ?? 'Product',
            'objects' => $objects,
        ]);
    }

    public function loadVariant(Request $request)
{
    $get = $request->input();
    \Log::info('Received input', ['input' => $get]);

    // Validate required fields
    if (!isset($get['product_id']) || !isset($get['language_id'])) {
        \Log::error('Missing product_id or language_id', ['input' => $get]);
        return response()->json([
            'error' => 'Thiếu product_id hoặc language_id',
            'variant' => null,
            'variantPrice' => null,
        ], 400);
    }

    // Check if attribute_id exists and is not empty
    if (!isset($get['attribute_id']) || empty($get['attribute_id'])) {
        \Log::warning('Missing or empty attribute_id', ['input' => $get]);
        return response()->json([
            'error' => 'Thiếu attribute_id',
            'variant' => null,
            'variantPrice' => null,
        ], 400);
    }

    try {
        $attributeId = $get['attribute_id'];
        \Log::info('Attribute ID before sort', ['attribute_id' => $attributeId]);

        // Sort attribute ID if function exists
        if (function_exists('sortAttributeId')) {
            $attributeId = sortAttributeId($attributeId);
            \Log::info('Attribute ID after sort', ['attribute_id' => $attributeId]);
        }

        // Find variant
        $variant = $this->productVariantRepository->findVariant(
            $attributeId, 
            $get['product_id'], 
            $get['language_id']
        );

        if (!$variant) {
            \Log::warning('Variant not found', [
                'attribute_id' => $attributeId,
                'product_id' => $get['product_id'],
                'language_id' => $get['language_id']
            ]);
            
            return response()->json([
                'error' => 'Không tìm thấy biến thể sản phẩm',
                'variant' => null,
                'variantPrice' => null,
            ], 404);
        }

        \Log::info('Found variant', ['variant' => $variant]);

        // Find variant promotion
        $variantPromotion = null;
        if (isset($variant->uuid) && !empty($variant->uuid)) {
            $variantPromotion = $this->promotionRepository->findPromotionByVariantUuid($variant->uuid);
            \Log::info('Found variant promotion', ['variantPromotion' => $variantPromotion]);
        }

        // Calculate variant price
        $variantPrice = null;
        if (function_exists('getVariantPrice')) {
            $variantPrice = getVariantPrice($variant, $variantPromotion);
            \Log::info('Calculated variant price', ['variantPrice' => $variantPrice]);
        } else {
            // Fallback price calculation
            $variantPrice = [
                'price' => $variant->price ?? 0,
                'sale_price' => $variant->sale_price ?? 0,
                'percent' => 0,
                'html' => ''
            ];
        }

        return response()->json([
            'variant' => $variant,
            'variantPrice' => $variantPrice,
            'success' => true
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in loadVariant', [
            'message' => $e->getMessage(),
            'input' => $get,
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'error' => 'Có lỗi xảy ra khi tải biến thể sản phẩm',
            'variant' => null,
            'variantPrice' => null,
        ], 500);
    }
}


    public function filter(Request $request)
    {
        $products = $this->productService->filter($request);

        $html = $this->renderFilterProduct($products);

        return response()->json([
            'data' => $html,
        ]);
    }

    public function renderFilterProduct($products)
    {

        $html = '';
        if (!is_null($products) && count($products)) {
            $html .= '<div class="uk-grid uk-grid-medium">';
            foreach ($products as  $product) {
                $name = $product->languages->first()->pivot->name;
                $canonical = write_url($product->languages->first()->pivot->canonical);
                $image = image($product->image);
                $price = getPrice($product);
                $catName = $product->product_catalogues->first()->languages->first()->pivot->name;
                $review = getReview($product);
                if (isset($product->attribute_concat)) {
                    $attributes = substr($product->attribute_concat, 0, -1);
                }

                $html .= '<div class="uk-width-large-1-4 mb20">';
                $html .= '<div class="product-item product">';
                if ($price['percent'] > 0) {
                    $html .= "<div class='badge badge-bg-1'>-{$price['percent']}%</div>";
                }
                $html .= "<a href='$canonical' class='image img-scaledown img-zoomin'><img src='$image' alt='$name'></a>";
                $html .= '<div class="info">';


                // $html .= "<div class='category-title'><a href='$canonical' title='$name'>$catName</a></div>";
                $html .= "<h3 class='title'><a href='$canonical' title='$name'>$name</a></h3>";
                $html .= '<div class="rating">';
                $html .= '<div class="uk-flex uk-flex-middle">';
                $html .= '<div class="star-rating">';
                $html .= '<div class="stars" style="--star-width: ' . $review['star'] . '%"></div>';
                $html .= '</div>';
                $html .= '<span class="rate-number">(' . $review['count'] . ' đánh giá)</span>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<div class="product-group">';
                $html .= '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
                $html .= $price['html'];
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';

            $html .= $products->links('pagination::bootstrap-4');
        } else {
            $html .= '<div class="no-result">Không có sản phẩm phù hợp</div>';
        }


        return $html;
    }

    public function wishlist(Request $request)
    {
        $id = $request->input('id');
        $wishlist = Cart::instance('wishlist')->content();
        $itemIndex = $wishlist->search(function ($item, $rowId) use ($id) {
            return $item->id === $id;
        });

        $response['code'] = 0;
        $response['message'] = '';
        if ($itemIndex !== false) {
            Cart::instance('wishlist')->remove($wishlist->keyBy('id')[$id]->rowId);

            $response['code'] = 1;
            $response['message'] = 'Sản phẩm đã được xóa khỏi danh sách yêu thích';
        } else {
            Cart::instance('wishlist')->add([
                'id' => $id,
                'name' => 'wishlist item',
                'qty' => 1,
                'price' => 0,
            ]);

            $response['code'] = 2;
            $response['message'] = 'Đã thêm sản phẩm vào danh sách yêu thích';
        }

        return response()->json($response);
    }
}
