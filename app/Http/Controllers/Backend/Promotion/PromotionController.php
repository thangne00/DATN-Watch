<?php

namespace App\Http\Controllers\Backend\Promotion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\PromotionServiceInterface  as PromotionService;
use App\Repositories\Interfaces\PromotionRepositoryInterface as PromotionRepository;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use App\Repositories\Interfaces\SourceRepositoryInterface as SourceRepository;

use App\Http\Requests\Promotion\StorePromotionRequest;
use App\Http\Requests\Promotion\UpdatePromotionRequest;

use App\Models\Language;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PromotionController extends Controller
{
    protected $promotionService;
    protected $promotionRepository;
    protected $languageRepository;
    protected $sourceRepository;
    protected $language;

    public function __construct(
        PromotionService $promotionService,
        PromotionRepository $promotionRepository,
        LanguageRepository $languageRepository,
        SourceRepository $sourceRepository,
    ){
        $this->promotionService = $promotionService;
        $this->promotionRepository = $promotionRepository;
        $this->languageRepository = $languageRepository;
        $this->sourceRepository = $sourceRepository;
        $this->middleware(function($request, $next){
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            return $next($request);
        });
    }

    public function index(Request $request){
        $this->authorize('modules', 'promotion.index');
        $promotions = $this->promotionService->paginate($request);
      
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Promotion'
        ];
        $config['seo'] = __('messages.promotion');
        $template = 'backend.promotion.promotion.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'promotions'
        ));
    }

    public function create(){
        $this->authorize('modules', 'promotion.create');
        $sources = $this->sourceRepository->all();
        $config = $this->config();
        $config['seo'] = __('messages.promotion');
        $config['method'] = 'create';
        $template = 'backend.promotion.promotion.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'sources'
        ));
    }

    public function store(StorePromotionRequest $request){
        if($this->promotionService->create($request, $this->language)){
            return redirect()->route('promotion.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('promotion.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        $this->authorize('modules', 'promotion.update');
        $promotion = $this->promotionRepository->findById($id);
        $sources = $this->sourceRepository->all();
        // dd($promotion->discountInformation);
        $config = $this->config();
        $config['seo'] = __('messages.promotion');
        $config['method'] = 'edit';
        $template = 'backend.promotion.promotion.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'promotion',
            'sources',
        ));
    }

    public function update($id, UpdatePromotionRequest $request){
        if($this->promotionService->update($id, $request, $this->language)){
            return redirect()->route('promotion.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('promotion.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'promotion.destroy');
        $config['seo'] = __('messages.promotion');
        $promotion = $this->promotionRepository->findById($id);
        $template = 'backend.promotion.promotion.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'promotion',
            'config',
        ));
    }

    public function destroy($id){
        if($this->promotionService->destroy($id)){
            return redirect()->route('promotion.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('promotion.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    public function translate($languageId, $promotionId){
        $this->authorize('modules', 'promotion.translate');
        $promotion = $this->promotionRepository->findById($promotionId);
        $promotion->jsonDescription = $promotion->description;
        $promotion->description = $promotion->description[$this->language];

        $promotionTranslate = new \stdClass;
        $promotionTranslate->description = ($promotion->jsonDescription[$languageId]) ?? '';

        $translate = $this->languageRepository->findById($languageId);
        $config = $this->config();
        $config['seo'] = __('messages.promotion');
        $config['method'] = 'create';
        $template = 'backend.promotion.promotion.translate';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'translate',
            'promotion',
            'promotionTranslate',
        ));
    }

    public function saveTranslate(Request $request){
        if($this->promotionService->saveTranslate($request, $this->language)){
            return redirect()->route('promotion.index')->with('success','Tạo bản dịch thành công');
        }
        return redirect()->route('promotion.index')->with('error','Tạo bản dịch không thành công. Hãy thử lại');
    }

    // ================ FRONTEND VOUCHER METHODS (UPDATED) ================

    /**
     * Apply promotion/voucher to cart (Frontend)
     */
    public function apply(Request $request)
    {
        try {
            $request->validate([
                'voucher_code' => 'required|string|max:50'
            ], [
                'voucher_code.required' => 'Vui lòng nhập mã giảm giá',
                'voucher_code.max' => 'Mã giảm giá không được quá 50 ký tự'
            ]);

            $promotionCode = strtoupper(trim($request->voucher_code));
            
            // Find promotion by code using your existing repository
            $promotion = $this->promotionRepository->findByCode($promotionCode);

            if (!$promotion || !$this->isPromotionValid($promotion)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn'
                ], 400);
            }

            // Get cart total from session
            $cartTotal = $this->getCartTotal();
            
            // Check minimum order amount from discountInformation
            $discountInfo = is_array($promotion->discountInformation) ? $promotion->discountInformation : [];
            $minimumOrderAmount = $discountInfo['minimum_order_amount'] ?? 0;
            
            if ($minimumOrderAmount > 0 && $cartTotal < $minimumOrderAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($minimumOrderAmount) . 'đ'
                ], 400);
            }

            // Calculate discount
            $discount = $this->calculatePromotionDiscount($promotion, $cartTotal);

            // Store promotion in session
            Session::put('applied_promotion', [
                'id' => $promotion->id,
                'code' => $promotion->code,
                'name' => $promotion->name,
                'type' => $promotion->type,
                'method' => $promotion->method,
                'discountType' => $promotion->discountType, // 'cash' or 'percent'
                'discountValue' => $promotion->discountValue,
                'maxDiscountValue' => $promotion->maxDiscountValue,
                'discount_amount' => $discount,
                'minimum_order_amount' => $minimumOrderAmount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công',
                'promotion' => [
                    'code' => $promotion->code,
                    'name' => $promotion->name,
                    'discount_amount' => $discount,
                    'formatted_discount' => number_format($discount) . 'đ'
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove promotion from cart (Frontend)
     */
    public function remove(Request $request)
    {
        try {
            Session::forget('applied_promotion');
            
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa mã giảm giá'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa mã giảm giá'
            ], 500);
        }
    }

    /**
     * Get available promotions for user (Frontend)
     */
    public function getAvailable(Request $request)
    {
        try {
            $cartTotal = $this->getCartTotal();
            
            $promotions = $this->promotionRepository->getAvailablePromotions($cartTotal);

            return response()->json([
                'success' => true,
                'promotions' => $promotions->map(function($promotion) {
                    $discountInfo = is_array($promotion->discountInformation) ? $promotion->discountInformation : [];
                    
                    return [
                        'id' => $promotion->id,
                        'code' => $promotion->code,
                        'name' => $promotion->name,
                        'type' => $promotion->type,
                        'method' => $promotion->method,
                        'discountType' => $promotion->discountType,
                        'discountValue' => $promotion->discountValue,
                        'maxDiscountValue' => $promotion->maxDiscountValue,
                        'minimum_order_amount' => $discountInfo['minimum_order_amount'] ?? 0,
                        'startDate' => $promotion->startDate ? $promotion->startDate->format('Y-m-d H:i:s') : null,
                        'endDate' => $promotion->endDate ? $promotion->endDate->format('Y-m-d H:i:s') : null,
                        'neverEndDate' => $promotion->neverEndDate,
                        'description' => is_array($promotion->description) 
                            ? ($promotion->description[$this->language] ?? $promotion->description[array_key_first($promotion->description)] ?? '')
                            : $promotion->description ?? ''
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lấy danh sách mã giảm giá: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current applied discount amount
     */
    public function getAppliedDiscount()
    {
        $appliedPromotion = Session::get('applied_promotion');
        
        return response()->json([
            'discount' => $appliedPromotion['discount_amount'] ?? 0,
            'code' => $appliedPromotion['code'] ?? null,
            'name' => $appliedPromotion['name'] ?? null,
            'success' => true
        ]);
    }

    /**
     * Debug session data
     */
    public function debugSession()
    {
        $cart = Session::get('cart');
        $appliedPromotion = Session::get('applied_promotion');
        
        return response()->json([
            'cart' => $cart,
            'applied_promotion' => $appliedPromotion,
            'all_session' => Session::all()
        ]);
    }

    /**
     * Clear applied voucher from session
     */
    public function clearVoucher()
    {
        Session::forget('applied_promotion');
        
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa voucher khỏi session'
        ]);
    }

    /**
     * Check if promotion is valid (UPDATED)
     */
    private function isPromotionValid($promotion)
    {
        $now = Carbon::now();
        
        // Check if promotion is published (use 2 based on your system)
        if (!$promotion->publish || $promotion->publish != 2) {
            return false;
        }
        
        // Check date range
        if ($promotion->startDate && $now->lt($promotion->startDate)) {
            return false;
        }
        
        if (!$promotion->neverEndDate && $promotion->endDate && $now->gt($promotion->endDate)) {
            return false;
        }
        
        // Check if has code
        if (empty($promotion->code)) {
            return false;
        }
        
        return true;
    }

    /**
     * Calculate promotion discount amount (UPDATED)
     */
    private function calculatePromotionDiscount($promotion, $cartTotal)
    {
        $discountType = $promotion->discountType; // 'cash' or 'percent'
        $discountValue = $promotion->discountValue;
        
        if ($discountType === 'percent') {
            $discount = ($cartTotal * $discountValue) / 100;
            
            // Apply maximum discount limit
            if ($promotion->maxDiscountValue && $discount > $promotion->maxDiscountValue) {
                $discount = $promotion->maxDiscountValue;
            }
        } else {
            // Cash discount
            $discount = $discountValue;
            
            // Discount cannot exceed cart total
            if ($discount > $cartTotal) {
                $discount = $cartTotal;
            }
        }

        return $discount;
    }

    /**
     * Get cart total from session
     */
    private function getCartTotal()
    {
        // Lấy từ session cart hoặc tính toán
        $cart = Session::get('cart', []);
        $total = 0;
        
        if (is_array($cart)) {
            foreach ($cart as $item) {
                if (is_array($item)) {
                    $price = $item['price'] ?? 0;
                    $quantity = $item['quantity'] ?? 1;
                    $total += $price * $quantity;
                }
            }
        }
        
        return $total;
    }

    /**
     * Get applied promotion discount for checkout
     */
    public static function getPromotionDiscount()
    {
        $appliedPromotion = Session::get('applied_promotion');
        
        if (!$appliedPromotion) {
            return 0;
        }

        return $appliedPromotion['discount_amount'] ?? 0;
    }

    /**
     * Mark promotion as used after successful order
     */
    public function markPromotionAsUsed()
    {
        $appliedPromotion = Session::get('applied_promotion');
        
        if ($appliedPromotion && isset($appliedPromotion['id'])) {
            try {
                // You can add usage tracking here if needed
                // For example, increment a used_count field if it exists
                
                // Remove from session
                Session::forget('applied_promotion');
                
                return true;
            } catch (\Exception $e) {
                \Log::error('Error marking promotion as used: ' . $e->getMessage());
                return false;
            }
        }
        
        return false;
    }

    private function config(){
        return [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                'backend/plugins/datetimepicker-master/build/jquery.datetimepicker.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/plugins/datetimepicker-master/build/jquery.datetimepicker.full.js',
                'backend/library/promotion.js',
            ]
        ];
    }
}