<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Voucher Component - API Integrated</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8fafc;
            padding: 20px;
        }
        
        .voucher-section {
            max-width: 500px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .voucher-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .panel-head {
            padding: 24px 24px 16px;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }
        
        .cart-heading {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }
        
        .cart-heading::before {
            content: '🎫';
            font-size: 20px;
        }
        
        .voucher-content {
            padding: 0 24px 24px;
        }
        
        .voucher-input-wrapper {
            margin-bottom: 20px;
        }
        
        .input-group {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }
        
        .input-field {
            flex: 1;
            position: relative;
        }
        
        .input-field input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            background: #ffffff;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .input-field input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .input-field input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }
        
        .apply-btn {
            padding: 16px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }
        
        .apply-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .apply-btn:active {
            transform: translateY(0);
        }
        
        .apply-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .voucher-message {
            padding: 14px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .voucher-message.success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #34d399;
        }
        
        .voucher-message.success::before {
            content: "✓";
            font-weight: bold;
        }
        
        .voucher-message.error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #f87171;
        }
        
        .voucher-message.error::before {
            content: "⚠";
            font-weight: bold;
        }
        
        .applied-voucher {
            margin-top: 20px;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .voucher-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 2px solid #10b981;
            border-radius: 16px;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .voucher-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #34d399);
        }
        
        .voucher-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .voucher-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }
        
        .voucher-details {
            flex: 1;
        }
        
        .voucher-name {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
            font-size: 16px;
        }
        
        .voucher-code {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #475569;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 6px;
            border: 1px solid #cbd5e1;
        }
        
        .voucher-discount {
            font-weight: 700;
            color: #10b981;
            font-size: 15px;
        }
        
        .btn-remove {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .btn-remove:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        
        .available-vouchers {
            margin-top: 24px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
        
        .show-vouchers-btn {
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .show-vouchers-btn:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .vouchers-list {
            margin-top: 16px;
            max-height: 320px;
            overflow-y: auto;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .loading-spinner {
            text-align: center;
            padding: 32px;
            color: #667eea;
            font-weight: 500;
        }
        
        .voucher-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .voucher-item:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: translateX(4px);
        }
        
        .voucher-item:last-child {
            border-bottom: none;
        }
        
        .voucher-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }
        
        .voucher-item:hover::before {
            transform: scaleY(1);
        }
        
        .voucher-item-code {
            font-weight: 700;
            color: #667eea;
            margin-bottom: 6px;
            font-size: 15px;
        }
        
        .voucher-item-name {
            color: #374151;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .voucher-item-discount {
            color: #10b981;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        
        .voucher-item-condition {
            color: #6b7280;
            font-size: 12px;
            font-style: italic;
        }
        
        .no-vouchers, .error-message {
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-style: italic;
        }
        
        .error-message {
            color: #ef4444;
        }
        
        /* Custom scrollbar */
        .vouchers-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .vouchers-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .vouchers-list::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 3px;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .voucher-section {
                margin: 0 10px;
                border-radius: 12px;
            }
            
            .panel-head {
                padding: 20px 20px 14px;
            }
            
            .voucher-content {
                padding: 0 20px 20px;
            }
            
            .input-group {
                flex-direction: column;
                gap: 12px;
            }
            
            .apply-btn {
                width: 100%;
                justify-content: center;
                padding: 18px;
            }
            
            .voucher-info {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }
            
            .btn-remove {
                position: absolute;
                top: 16px;
                right: 16px;
            }
            
            .voucher-details {
                width: 100%;
            }
        }
        
        /* Hover effects and animations */
        .voucher-section:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
        
        /* Loading animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .fa-spinner {
            animation: spin 1s linear infinite;
        }
        
        /* Success pulse animation */
        .voucher-message.success {
            animation: slideDown 0.3s ease, pulse 2s ease-in-out;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
    </style>
</head>
<body>
    <div class="voucher-section mt-20">
        <div class="panel-head">
            <h3 class="cart-heading"><span>Mã giảm giá</span></h3>
        </div>
        
        <div class="voucher-content">
            <!-- Voucher Input Form -->
            <div class="voucher-input-wrapper" id="voucherInputWrapper">
                <div class="input-group">
                    <div class="input-field">
                        <input type="text" 
                               id="voucherCode" 
                               placeholder="Nhập mã giảm giá của bạn..." 
                               maxlength="50">
                    </div>
                    <button type="button" 
                            id="applyVoucherBtn" 
                            class="apply-btn">
                        <i class="fas fa-ticket-alt"></i> Áp dụng
                    </button>
                </div>
                <div id="voucherMessage" class="voucher-message" style="display: none;"></div>
            </div>

            <!-- Applied Voucher Display -->
            <div class="applied-voucher" id="appliedVoucher" style="display: none;">
                <div class="voucher-card">
                    <div class="voucher-info">
                        <div class="voucher-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="voucher-details">
                            <div class="voucher-name" id="appliedVoucherName">Giảm giá 20%</div>
                            <div class="voucher-code" id="appliedVoucherCode">SAVE20</div>
                            <div class="voucher-discount" id="appliedVoucherDiscount">Giảm 100.000đ</div>
                        </div>
                        <div class="voucher-actions">
                            <button type="button" id="removeVoucherBtn" class="btn-remove" title="Xóa mã giảm giá">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Vouchers Section -->
            <div class="available-vouchers">
                <button type="button" id="showAvailableVouchersBtn" class="show-vouchers-btn">
                    <i class="fas fa-tags"></i> Xem các mã giảm giá có sẵn
                </button>
                
                <div id="availableVouchersList" class="vouchers-list" style="display: none;">
                    <div class="loading-spinner" id="vouchersLoading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Đang tải voucher...
                    </div>
                    <div id="vouchersContainer">
                        <!-- Vouchers will be loaded from API -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden input to store applied voucher for form submission -->
    <input type="hidden" name="applied_voucher_code" id="appliedVoucherCodeInput" value="">

    <!-- jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
        /**
         * Voucher Manager Class - Integrated with Laravel API
         */
        class VoucherManager {
            constructor() {
                this.init();
                this.checkAppliedVoucher();
            }

            init() {
                // Set CSRF token for AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                this.bindEvents();
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
                        
                        // Trigger custom event for cart update
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
                        
                        // Trigger custom event for cart update
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

                // Auto hide messages
                const hideTimeout = type === 'error' ? 5000 : 3000;
                setTimeout(() => {
                    $messageDiv.hide();
                }, hideTimeout);
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
        }

        // Initialize when document is ready
        $(document).ready(function() {
            window.voucherManager = new VoucherManager();
        });
    </script>


<!-- Cart Total Update Script -->
    <script>
    $(document).ready(function() {
        // Lấy tổng tiền gốc từ cart hiện tại
        let originalSubtotal = 14800000; // 14.800.000đ - bạn có thể thay bằng PHP variable
        let currentDiscount = 0;
        
        // Lắng nghe sự kiện khi áp dụng voucher
        $(document).on('voucher:applied', function(event, promotion) {
            currentDiscount = promotion.discount_amount;
            updateCartDisplay();
            showNotification('Đã áp dụng mã giảm giá thành công!', 'success');
        });
        
        // Lắng nghe sự kiện khi xóa voucher
        $(document).on('voucher:removed', function() {
            currentDiscount = 0;
            updateCartDisplay();
            showNotification('Đã xóa mã giảm giá', 'info');
        });
        
        function updateCartDisplay() {
            const finalTotal = originalSubtotal - currentDiscount;
            
            // Update cart summary in parent window (trang cart thật)
            if (window.parent && window.parent !== window) {
                // Nếu voucher component được load trong iframe
                window.parent.postMessage({
                    type: 'voucher_update',
                    discount: currentDiscount,
                    finalTotal: finalTotal
                }, '*');
            } else {
                // Update trực tiếp trên trang hiện tại
                updatePageTotals(finalTotal);
            }
        }
        
        function updatePageTotals(finalTotal) {
            // Tìm và cập nhật các element hiển thị tổng tiền
            const totalSelectors = [
                '[data-total]',
                '.total-amount',
                '.final-total',
                '#finalTotal',
                '.cart-total'
            ];
            
            totalSelectors.forEach(selector => {
                $(selector).text(formatCurrency(finalTotal));
            });
            
            // Cập nhật tất cả text chứa "Tổng cộng"
            $('*:contains("Tổng cộng")').each(function() {
                const $this = $(this);
                if ($this.children().length === 0) {
                    // Text node
                    const text = $this.text();
                    if (text.includes('đ')) {
                        $this.text('Tổng cộng: ' + formatCurrency(finalTotal));
                    }
                }
            });
            
            // Hiển thị dòng giảm giá
            showDiscountInCart();
        }
        
        function showDiscountInCart() {
            // Remove existing discount row
            $('.voucher-discount-row').remove();
            
            if (currentDiscount > 0) {
                // Find cart summary area and add discount row
                const discountHtml = `
                    <div class="voucher-discount-row" style="
                        display: flex; 
                        justify-content: space-between; 
                        padding: 8px 0; 
                        border-top: 1px dashed #e2e8f0;
                        color: #10b981; 
                        font-weight: 600;
                        margin: 8px 0;
                    ">
                        <span>Giảm giá:</span>
                        <span>-${formatCurrency(currentDiscount)}</span>
                    </div>
                `;
                
                // Try to find appropriate place to insert discount
                const targetElements = [
                    $('.cart-summary'),
                    $('#cart-summary'),
                    $('[class*="summary"]'),
                    $('*:contains("Tổng cộng")').parent()
                ];
                
                for (let $target of targetElements) {
                    if ($target.length > 0) {
                        $target.append(discountHtml);
                        break;
                    }
                }
            }
        }
        
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }
        
        function showNotification(message, type) {
            const icon = type === 'success' ? 'check' : 'info';
            const color = type === 'success' ? '#10b981' : '#3b82f6';
            
            const notification = $(`
                <div class="voucher-notification" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${color};
                    color: white;
                    padding: 12px 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    z-index: 9999;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                ">
                    <i class="fas fa-${icon}-circle"></i>
                    ${message}
                </div>
            `);
            
            $('body').append(notification);
            
            // Auto remove
            setTimeout(() => {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
        
        // Check for existing applied voucher on page load
        const existingVoucherCode = $('#appliedVoucherCodeInput').val();
        if (existingVoucherCode) {
            // Estimate discount from session or make API call
            $.get('/cart/get-applied-discount')
                .done(function(response) {
                    if (response.discount > 0) {
                        currentDiscount = response.discount;
                        updateCartDisplay();
                    }
                })
                .fail(function() {
                    console.log('Could not get current discount amount');
                });
        }
    });
    </script>




</body>
</html>