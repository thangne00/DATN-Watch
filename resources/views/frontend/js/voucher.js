/**
 * Voucher/Promotion Management JavaScript
 * File: public/frontend/js/voucher.js
 */

class VoucherManager {
    constructor() {
        this.init();
        this.checkAppliedVoucher();
    }

    init() {
        // Bind event listeners
        this.bindEvents();
        
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    bindEvents() {
        // Apply voucher button
        $(document).on('click', '#applyVoucherBtn', () => {
            this.applyVoucher();
        });

        // Remove voucher button
        $(document).on('click', '#removeVoucherBtn', () => {
            this.removeVoucher();
        });

        // Enter key on voucher input
        $(document).on('keypress', '#voucherCode', (e) => {
            if (e.which === 13) {
                e.preventDefault();
                this.applyVoucher();
            }
        });

        // Show available vouchers
        $(document).on('click', '#showAvailableVouchersBtn', () => {
            this.toggleAvailableVouchers();
        });

        // Click on available voucher item
        $(document).on('click', '.voucher-item', (e) => {
            const code = $(e.currentTarget).data('code');
            if (code) {
                $('#voucherCode').val(code);
                this.applyVoucher();
            }
        });
    }

    async applyVoucher() {
        const voucherCode = $('#voucherCode').val().trim();
        
        if (!voucherCode) {
            this.showMessage('Vui lòng nhập mã giảm giá', 'error');
            return;
        }

        // Show loading state
        const $btn = $('#applyVoucherBtn');
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

        try {
            const response = await $.ajax({
                url: '/voucher/apply',
                method: 'POST',
                data: {
                    voucher_code: voucherCode
                }
            });

            if (response.success) {
                this.showAppliedVoucher(response.promotion);
                this.showMessage(response.message, 'success');
                $('#appliedVoucherCodeInput').val(response.promotion.code);
                
                // Hide voucher input form
                $('#voucherInputWrapper').hide();
                
                // Update cart summary if function exists
                if (typeof this.updateCartSummary === 'function') {
                    this.updateCartSummary();
                }
                
                // Trigger custom event
                $(document).trigger('voucher:applied', [response.promotion]);
            } else {
                this.showMessage(response.message, 'error');
            }

        } catch (error) {
            console.error('Voucher apply error:', error);
            
            let message = 'Có lỗi xảy ra khi áp dụng mã giảm giá';
            if (error.responseJSON && error.responseJSON.message) {
                message = error.responseJSON.message;
            }
            
            this.showMessage(message, 'error');
        } finally {
            // Restore button state
            $btn.html(originalText).prop('disabled', false);
        }
    }

    async removeVoucher() {
        try {
            const response = await $.ajax({
                url: '/voucher/remove',
                method: 'POST'
            });

            if (response.success) {
                this.hideAppliedVoucher();
                this.showMessage(response.message, 'success');
                $('#appliedVoucherCodeInput').val('');
                
                // Show voucher input form
                $('#voucherInputWrapper').show();
                $('#voucherCode').val('');
                
                // Update cart summary if function exists
                if (typeof this.updateCartSummary === 'function') {
                    this.updateCartSummary();
                }
                
                // Trigger custom event
                $(document).trigger('voucher:removed');
            } else {
                this.showMessage(response.message, 'error');
            }

        } catch (error) {
            console.error('Voucher remove error:', error);
            this.showMessage('Có lỗi xảy ra khi xóa mã giảm giá', 'error');
        }
    }

    async toggleAvailableVouchers() {
        const $list = $('#availableVouchersList');
        
        if ($list.is(':visible')) {
            $list.hide();
            $('#showAvailableVouchersBtn').html('<i class="fas fa-tags"></i> Xem các mã giảm giá có sẵn');
            return;
        }

        // Show loading
        $list.show();
        $('#vouchersLoading').show();
        $('#vouchersContainer').empty();

        try {
            const response = await $.ajax({
                url: '/voucher/available',
                method: 'GET'
            });

            if (response.success && response.promotions) {
                this.renderAvailableVouchers(response.promotions);
                $('#showAvailableVouchersBtn').html('<i class="fas fa-chevron-up"></i> Ẩn mã giảm giá');
            } else {
                $('#vouchersContainer').html('<div class="no-vouchers">Không có mã giảm giá nào khả dụng</div>');
            }

        } catch (error) {
            console.error('Get available vouchers error:', error);
            $('#vouchersContainer').html('<div class="error-message">Có lỗi xảy ra khi tải mã giảm giá</div>');
        } finally {
            $('#vouchersLoading').hide();
        }
    }

    renderAvailableVouchers(vouchers) {
        const $container = $('#vouchersContainer');
        $container.empty();

        if (vouchers.length === 0) {
            $container.html('<div class="no-vouchers">Không có mã giảm giá nào khả dụng</div>');
            return;
        }

        vouchers.forEach(voucher => {
            // Use correct field names from API response
            const discountText = voucher.discountType === 'percent' 
                ? `Giảm ${voucher.discountValue}%`
                : `Giảm ${this.formatCurrency(voucher.discountValue)}`;

            const conditionText = voucher.minimum_order_amount > 0 
                ? `Đơn tối thiểu ${this.formatCurrency(voucher.minimum_order_amount)}`
                : 'Áp dụng cho tất cả đơn hàng';

            const maxDiscountText = voucher.maxDiscountValue 
                ? ` (tối đa ${this.formatCurrency(voucher.maxDiscountValue)})`
                : '';

            const voucherHtml = `
                <div class="voucher-item" data-code="${voucher.code}">
                    <div class="voucher-item-code">${voucher.code}</div>
                    <div class="voucher-item-name">${voucher.name}</div>
                    <div class="voucher-item-discount">${discountText}${maxDiscountText}</div>
                    <div class="voucher-item-condition">${conditionText}</div>
                </div>
            `;

            $container.append(voucherHtml);
        });
    }

    showAppliedVoucher(promotion) {
        $('#appliedVoucherName').text(promotion.name);
        $('#appliedVoucherCode').text(promotion.code);
        $('#appliedVoucherDiscount').text(`Tiết kiệm: ${promotion.formatted_discount}`);
        $('#appliedVoucher').show();
    }

    hideAppliedVoucher() {
        $('#appliedVoucher').hide();
        $('#appliedVoucherName').text('');
        $('#appliedVoucherCode').text('');
        $('#appliedVoucherDiscount').text('');
    }

    showMessage(message, type) {
        const $messageDiv = $('#voucherMessage');
        $messageDiv
            .removeClass('success error')
            .addClass(type)
            .text(message)
            .show();

        // Auto hide after 5 seconds for error messages
        if (type === 'error') {
            setTimeout(() => {
                $messageDiv.hide();
            }, 5000);
        } else {
            setTimeout(() => {
                $messageDiv.hide();
            }, 3000);
        }
    }

    checkAppliedVoucher() {
        // Check if there's an applied voucher from session
        const appliedCode = $('#appliedVoucherCodeInput').val();
        
        if (appliedCode) {
            // Hide input form and show applied voucher
            $('#voucherInputWrapper').hide();
            $('#appliedVoucher').show();
        }
    }

    formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
    }

    // Method to update cart summary (to be implemented based on your cart structure)
    updateCartSummary() {
        // This should trigger a cart recalculation
        console.log('Updating cart summary...');
        
        // Example implementation - you can customize this based on your cart structure
        try {
            // If you have a cart update function, call it
            if (typeof window.updateCartTotals === 'function') {
                window.updateCartTotals();
            }
            
            // Or trigger a custom event that other scripts can listen to
            $(document).trigger('cart:update');
            
            // You might want to reload specific sections of the page
            // $('#cart-summary').load(location.href + ' #cart-summary');
            
        } catch (error) {
            console.error('Error updating cart summary:', error);
        }
    }
}

// Initialize when document is ready
$(document).ready(function() {
    window.voucherManager = new VoucherManager();
    
    // Add some styling for the no-vouchers and error messages
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .no-vouchers, .error-message {
                padding: 20px;
                text-align: center;
                color: #6b7280;
                font-style: italic;
            }
            .error-message {
                color: #ef4444;
            }
            .voucher-message.success {
                background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
                color: #065f46;
                border: 1px solid #34d399;
                padding: 12px 16px;
                border-radius: 8px;
                margin: 10px 0;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .voucher-message.error {
                background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
                color: #991b1b;
                border: 1px solid #f87171;
                padding: 12px 16px;
                border-radius: 8px;
                margin: 10px 0;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .voucher-message.success::before {
                content: "✓";
                font-weight: bold;
            }
            .voucher-message.error::before {
                content: "⚠";
                font-weight: bold;
            }
        `)
        .appendTo('head');
});

// Export for use in other scripts if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = VoucherManager;
}