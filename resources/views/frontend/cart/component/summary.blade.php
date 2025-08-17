{{-- resources/views/frontend/cart/component/summary.blade.php --}}

@php
    $subtotal = 0;
    
    // Calculate subtotal using $carts variable (same as item.blade.php)
    if (isset($carts) && count($carts) && !is_null($carts)) {
        foreach ($carts as $cart) {
            $price = $cart->price ?? 0;
            $quantity = $cart->qty ?? 1;
            $subtotal += $price * $quantity;
        }
    }
    
    // Get applied promotion discount
    $appliedPromotion = session('applied_promotion');
    $promotionDiscount = $appliedPromotion['discount_amount'] ?? 0;
    
    // Calculate shipping (you can modify this based on your logic)
    $shippingCost = 0; // Free shipping or calculate based on your rules
    
    // Calculate final total
    $finalTotal = $subtotal - $promotionDiscount + $shippingCost;
@endphp

<div class="cart-summary" id="cartSummary">
    <div class="panel-head">
        <h3 class="cart-heading"><span>Tổng đơn hàng</span></h3>
    </div>
    
    <div class="summary-content">
        {{-- Subtotal --}}
        <div class="summary-row">
            <span class="summary-label">Tạm tính:</span>
            <span class="summary-value" id="subtotalAmount">{{ convert_price($subtotal, true) }}đ</span>
        </div>
        
        {{-- Promotion Discount --}}
        @if($appliedPromotion && $promotionDiscount > 0)
        <div class="summary-row discount-row">
            <span class="summary-label">
                <i class="fas fa-ticket-alt text-success"></i>
                Giảm giá ({{ $appliedPromotion['code'] }}):
            </span>
            <span class="summary-value discount-value">-{{ convert_price($promotionDiscount, true) }}đ</span>
        </div>
        @endif
        
        {{-- Shipping --}}
        <div class="summary-row">
            <span class="summary-label">Phí vận chuyển:</span>
            <span class="summary-value" id="shippingAmount">
                @if($shippingCost > 0)
                    {{ convert_price($shippingCost, true) }}đ
                @else
                    <span class="text-success">Miễn phí</span>
                @endif
            </span>
        </div>
        
        {{-- Divider --}}
        <div class="summary-divider"></div>
        
        {{-- Final Total --}}
        <div class="summary-row total-row">
            <span class="summary-label total-label">Tổng cộng:</span>
            <span class="summary-value total-value" id="finalTotalAmount">{{ convert_price($finalTotal, true) }}đ</span>
        </div>
        
        {{-- Savings Display --}}
        @if($promotionDiscount > 0)
        <div class="savings-info">
            <i class="fas fa-check-circle text-success"></i>
            <span class="savings-text">Bạn đã tiết kiệm được {{ convert_price($promotionDiscount, true) }}đ!</span>
        </div>
        @endif
    </div>
    
    {{-- Hidden inputs for form submission --}}
    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
    <input type="hidden" name="promotion_discount" value="{{ $promotionDiscount }}">
    <input type="hidden" name="shipping_cost" value="{{ $shippingCost }}">
    <input type="hidden" name="final_total" value="{{ $finalTotal }}">
</div>

<style>
.cart-summary {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
}

.summary-content {
    space-y: 12px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: 14px;
}

.summary-label {
    color: #666;
    flex: 1;
}

.summary-value {
    font-weight: 500;
    color: #333;
    text-align: right;
}

.discount-row {
    background: #f8f9fa;
    margin: 0 -10px;
    padding: 12px 10px;
    border-radius: 6px;
    border-left: 4px solid #28a745;
}

.discount-row .summary-label {
    color: #28a745;
    font-weight: 500;
}

.discount-value {
    color: #28a745 !important;
    font-weight: 600;
}

.summary-divider {
    border-top: 2px solid #e0e0e0;
    margin: 15px 0;
}

.total-row {
    font-size: 16px;
    font-weight: 600;
    padding: 12px 0;
    background: #f8f9fa;
    margin: 0 -10px;
    padding-left: 10px;
    padding-right: 10px;
    border-radius: 6px;
}

.total-label {
    color: #333 !important;
    font-size: 16px;
}

.total-value {
    color: #007bff !important;
    font-size: 18px;
    font-weight: 700;
}

.savings-info {
    text-align: center;
    padding: 12px;
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-radius: 6px;
    margin-top: 15px;
    border: 1px solid #c3e6cb;
}

.savings-text {
    color: #155724;
    font-weight: 500;
    font-size: 14px;
    margin-left: 8px;
}

.text-success {
    color: #28a745 !important;
}

@media (max-width: 768px) {
    .summary-row {
        font-size: 13px;
    }
    
    .total-row {
        font-size: 14px;
    }
    
    .total-value {
        font-size: 16px;
    }
}
</style>

<script>
// Real-time cart summary update
function updateCartSummaryRealTime() {
    let subtotal = 0;
    
    // Calculate subtotal from current cart items displayed
    $('.cart-item').each(function() {
        const qty = parseInt($(this).find('.input-qty').val()) || 0;
        const pricePerItem = $(this).data('price') || 0; // You need to add data-price to cart items
        subtotal += pricePerItem * qty;
    });
    
    // Update display with formatting
    $('#subtotalAmount').text(new Intl.NumberFormat('vi-VN').format(subtotal) + 'đ');
    $('#finalTotalAmount').text(new Intl.NumberFormat('vi-VN').format(subtotal) + 'đ');
    
    // Update hidden inputs
    $('input[name="subtotal"]').val(subtotal);
    $('input[name="final_total"]').val(subtotal);
}

// Update cart summary when voucher is applied/removed
$(document).on('voucher:applied voucher:removed cart:update', function() {
    // AJAX call to refresh the summary from server
    updateCartSummary();
});

function updateCartSummary() {
    $.ajax({
        url: '/cart/summary',
        method: 'GET',
        success: function(response) {
            if (response.html) {
                $('#cartSummary').replaceWith(response.html);
            }
        },
        error: function(error) {
            console.error('Error updating cart summary:', error);
            // Fallback to real-time calculation
            updateCartSummaryRealTime();
        }
    });
}

// Initialize real-time updates
$(document).ready(function() {
    // Bind quantity change events
    $(document).on('input change', '.input-qty', function() {
        updateCartSummaryRealTime();
    });
    
    $(document).on('click', '.btn-qty', function() {
        // Small delay to ensure input value is updated
        setTimeout(updateCartSummaryRealTime, 50);
    });
});
</script>