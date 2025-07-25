<?php   

if(!function_exists('convertRevenueChartData')){
    function convertRevenueChartData($chartData, $data = 'monthly_revenue', $label = 'month' , $text = 'Tháng'){
        $newArray = [];
        if(!is_null($chartData) && count($chartData)){
            foreach($chartData as $key => $val){
                $newArray['data'][] = $val->{$data};
                $newArray['label'][] = $text.' '.$val->{$label};
            }
        }
        return $newArray;
    }
}


if(!function_exists('pre')){
    function pre($data = ''){
        echo '<pre>';
        print_r($data);
        echo '<pre>';
        die();
    }
}

if(!function_exists('image')){
    function image($image){
        

        if(is_null($image)) return 'backend/img/not-found.jpg';

        $image = str_replace('/public/', '/', $image);

        return $image;
    }
}


if(!function_exists('convert_price')){
    function convert_price(mixed $price = '', $flag = false){
        if($price === null) return 0;
        return ($flag === false) ? str_replace('.','', $price) : number_format($price, 0, ',', '.');
    }
}

if(!function_exists('getPercent')){
    function getPercent($product = null, $discountValue = 0){
        return ($product->price > 0) ? round($discountValue/$product->price*100) : 0;
    
    }
}

if(!function_exists('getPromotionPrice')){
    function getPromotionPrice($priceMain = 0, $discountValue = 0){
       

        return $priceMain - $discountValue;
    
    }


if(!function_exists('getPrice')){
    function getPrice($product = null){
        $result = [
            'price' => $product->price, 
            'priceSale' => 0,
            'percent' => 0, 
            'html' => ''
        ];

        if($product->price == 0){

            $result['html'] .= '<div class="price mt10">';
                $result['html'] .= '<div class="price-sale">Liên Hệ</div>';
            $result['html'] .= '</div>';
            return $result;
        }

        if(isset($product->promotions) && isset($product->promotions->discountType)){
            $result['percent'] = getPercent($product, $product->promotions->discount);
            if($product->promotions->discountValue > 0){
                $result['priceSale'] = getPromotionPrice($product->price, $product->promotions->discount);
            }
        }
        $result['html'] .= '<div class="price uk-flex uk-flex-middle mt10">';
            $result['html'] .= '<div class="price-sale">'.(($result['priceSale'] > 0) ? convert_price($result['priceSale'], true) : convert_price($result['price'], true) ).'đ</div>';
            if($result['priceSale'] > 0){
                $result['html'] .= '<div class="price-old uk-flex uk-flex-middle">'.convert_price($result['price'], true).'đ <div class="percent"><div class="percent-value">-'.$result['percent'].'%</div></div></div>';
                
            }
        $result['html'] .= '</div>';
        return $result;
    }
}

if(!function_exists('getVariantPrice')){
    function getVariantPrice($variant, $variantPromotion){
        $result = [
            'price' => $variant->price, 
            'priceSale' => 0,
            'percent' => 0, 
            'html' => ''
        ];

        if($variant->price == 0){

            $result['html'] .= '<div class="price mt10">';
                $result['html'] .= '<div class="price-sale">Liên Hệ</div>';
            $result['html'] .= '</div>';
            return $result;
        }

        if(!is_null($variantPromotion)){
            $result['percent'] = getPercent($variant, $variantPromotion->discount);
            $result['priceSale'] = getPromotionPrice($variant->price, $variantPromotion->discount);
        }


        $result['html'] .= '<div class="price-sale">'.(($result['priceSale'] > 0) ? convert_price($result['priceSale'], true) : convert_price($result['price'], true) ).'đ</div>';
        if($result['priceSale'] !== $result['price']){
            $result['html'] .= '<div class="price-old">'.convert_price($result['price'], true).'đ <div class="percent"><div class="percent-value">-'.$result['percent'].'%</div></div></div>';
        }
        return $result;
    }
}


if(!function_exists('getReview')){
    function getReview($product = ''){

        $totalReviews = $product->reviews()->count();
        $totalRate = number_format($product->reviews()->avg('score'), 1);
        $starPercent = ($totalReviews == 0) ? '0' : $totalRate/5*100;
    

        return [
            'star' => $starPercent,
            'count' => $totalReviews,
        ];
    }
}

if(!function_exists('recursive')){
    function recursive($data, $parentId = 0){
        $temp = [];
        if(!is_null($data) && count($data)){
            foreach($data as $key => $val){
                if($val->parent_id == $parentId){
                    $temp[] = [
                        'item' => $val,
                        'children' => recursive($data, $val->id)
                    ];
                }
            }
        }
        return $temp;
    }
}




if(!function_exists('renderQuickBuy')){
    function renderQuickBuy($product, string $canonical = '', string $name = ''){

        $class = 'btn-addCart';
        $openModal = '';
        if(isset($product->product_variants) && count($product->product_variants)){
            $class = '';
            $canonical = '#popup';
            $openModal = 'data-uk-modal';
        }

        $html = '<a href="'.$canonical.'" '.$openModal.' title="'.$name.'" class="'.$class.'">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g>
                    <path d="M24.4941 3.36652H4.73614L4.69414 3.01552C4.60819 2.28593 4.25753 1.61325 3.70863 1.12499C3.15974 0.636739 2.45077 0.366858 1.71614 0.366516L0.494141 0.366516V2.36652H1.71614C1.96107 2.36655 2.19748 2.45647 2.38051 2.61923C2.56355 2.78199 2.68048 3.00626 2.70914 3.24952L4.29414 16.7175C4.38009 17.4471 4.73076 18.1198 5.27965 18.608C5.82855 19.0963 6.53751 19.3662 7.27214 19.3665H20.4941V17.3665H7.27214C7.02705 17.3665 6.79052 17.2764 6.60747 17.1134C6.42441 16.9505 6.30757 16.7259 6.27914 16.4825L6.14814 15.3665H22.3301L24.4941 3.36652ZM20.6581 13.3665H5.91314L4.97214 5.36652H22.1011L20.6581 13.3665Z" fill="#253D4E"></path>
                    <path d="M7.49414 24.3665C8.59871 24.3665 9.49414 23.4711 9.49414 22.3665C9.49414 21.2619 8.59871 20.3665 7.49414 20.3665C6.38957 20.3665 5.49414 21.2619 5.49414 22.3665C5.49414 23.4711 6.38957 24.3665 7.49414 24.3665Z" fill="#253D4E"></path>
                    <path d="M17.4941 24.3665C18.5987 24.3665 19.4941 23.4711 19.4941 22.3665C19.4941 21.2619 18.5987 20.3665 17.4941 20.3665C16.3896 20.3665 15.4941 21.2619 15.4941 22.3665C15.4941 23.4711 16.3896 24.3665 17.4941 24.3665Z" fill="#253D4E"></path>
                    </g>
                    <defs>
                    <clipPath>
                    <rect width="24" height="24" fill="white" transform="translate(0.494141 0.366516)"></rect>
                    </clipPath>
                    </defs>
                </svg>
        </a>';
    return $html;
    }
}

}


if(!function_exists('categorySelectRaw')){
    function categorySelectRaw($table = 'products'){
        $rawQuery = "
            (
                SELECT COUNT(id) 
                FROM {$table}s
                JOIN {$table}_catalogue_{$table} as tb3 ON tb3.{$table}_id = {$table}s.id
                WHERE tb3.{$table}_catalogue_id IN (
                    SELECT id
                    FROM {$table}_catalogues as parent_category
                    WHERE lft >= (SELECT lft FROM {$table}_catalogues as pc WHERE pc.id = {$table}_catalogues.id)
                    AND rgt <= (SELECT rgt FROM {$table}_catalogues as pc WHERE pc.id = {$table}_catalogues.id)
                )
            ) as {$table}s_count 
        "; 
        return $rawQuery;
    }
}


if(!function_exists('sortString')){
    function sortString($string = ''){
        $extract = explode(',', $string);
        $extract = array_map('trim', $extract);
        sort($extract, SORT_NUMERIC);
        $newArray = implode(',', $extract);
        return $newArray;
    }
}

if(!function_exists('sortAttributeId')){
    function sortAttributeId(array $attributeId = []){
        sort($attributeId, SORT_NUMERIC);
        $attributeId = implode(',', $attributeId);
        return $attributeId;
    }
}


if(!function_exists('vnpayConfig')){
    function vnpayConfig(){
        return [
            'vnp_Url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
            'vnp_Returnurl' => write_url('return/vnpay'),
            'vnp_TmnCode' => 'RLE42FCR',
            'vnp_HashSecret' => 'OQPUUZRVSSJASOQVUQHHURHBXGDIMBTU',
            'vnp_apiUrl' => 'http://sandbox.vnpayment.vn/merchant_webapi/merchant.html',
            'apiUrl' => 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction'
        ];
    }
}



if(!function_exists('execPostRequest')){
    function execPostRequest($url, $data){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}


if(!function_exists('getReviewName')){
    function getReviewName($string){
        // $string = Nguyễn Công Tuấn
        $words = explode(' ', $string);
        $initialize = '';
        foreach($words as $key => $val){
            $initialize .= strtoupper(substr($val, 0, 1));
        }
        return $initialize;
    }
}


if(!function_exists('generateStar')){
    function generateStar($rating){
        $rating = max(1, min(5, $rating));
        $output = '<div class="review-star">';
            for($i = 1; $i <= $rating; $i++){
                $output .= '<i class="fa fa-star"></i>';
            }
            for($i = $rating + 1; $i <= 5; $i++){
                $output .= '<i class="fa fa-star-o"></i>';
            }
        $output .= '</div>';
        return $output;
    }
}


if(!function_exists('convertCombineArray')){
    function convertCombineArray(mixed $data, $mix_1 = ''){
        $array = [];
        foreach($data as $key => $val){
            $array[$val->id] = (($mix_1 != '') ? $val->{$mix_1} : $val->code).' / '.$val->phone;
        }
        return $array;
    }
}


if(!function_exists('convertArray')){
    function convertArray($datas){
        $id = [];
        foreach ($datas as $data) {
            $id[]= $data->id;
        }
        return $id;
    }
}

