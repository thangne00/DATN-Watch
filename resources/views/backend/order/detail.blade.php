@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['detail']['title']])

<div class="order-wrapper">
    <div class="row">
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <div class="ibox-title-left">
                            <span>Chi tiết  {{ $order->code }}</span>
                            <span class="badge">
                                <div class="badge__tip"></div>
                                <div class="badge-text"> {{ __('cart.delivery')[$order->delivery] }}</div>
                            </span>
                            <span class="badge">
                                <div class="badge__tip"></div>
                                <div class="badge-text"> {{ __('cart.payment')[$order->payment] }}</div>
                            </span>
                        </div>
                        <div class="ibox-title-right">
                            Nguồn: Website
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table-order">
                        <tbody>
                        @foreach($order->products as $key => $val)
                            @php
                                $name = $val->pivot->name;
                                $qty = $val->pivot->qty;
                                $price = convert_price($val->pivot->price, true);
                                $priceOriginal = convert_price($val->pivot->priceOriginal, true);
                                $subtotal = convert_price($val->pivot->price * $qty, true);
                                $image = image($val->image);
                            @endphp
                            <tr class="order-item">
                                <td>
                                    <div class="image">
                                        <span class="image img-scaledown"><img src="{{ $image; }}" alt=""></span>
                                    </div>
                                </td>
                                <td style="width:285px;">
                                    <div class="order-item-name" title=""{{ $name }}">{{ $name }}</div>
                <div class="order-item-voucher">Mã giảm giá: Không có</div>
                </td>
                <td>
                    <div class="order-item-price">{{ $price }} ₫</div>
                </td>
                <td>
                    <div class="order-item-times">x</div>
                </td>
                <td>
                    <div class="order-item-qty">{{ $qty }}</div>
                </td>
                <td>
                    <div class="order-item-subtotal">
                        {{ $subtotal }} ₫
                    </div>
                </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right">Tổng tạm</td>
                    <td class="text-right">{{ convert_price($order->cart['cartTotal'], true) }} ₫</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">Giảm giá</td>
                    <td class="text-right">- {{ convert_price($order->promotion['discount'], true) }} ₫</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">Vận chuyển</td>
                    <td class="text-right">0 ₫</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right"><strong>Tổng cuối</strong></td>
                    <td class="text-right" style="font-size:18px;"><strong
                            style="color:blue;">{{ convert_price($order->cart['cartTotal'] - $order->promotion['discount'], true) }}
                            ₫</strong></td>
                </tr>
                </tbody>

                </table>


            </div>
            <div class="payment-confirm confirm-box">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="uk-flex uk-flex-middle">
                        <span class="icon"><img
                                src="{{ ($order->confirm == 'pending') ? asset('backend/img/warning.png') : asset('backend/img/correct.png') }}"
                                alt=""></span>
                        <div class="payment-title">
                            <div class="text_1">
                                <span class="isConfirm">{{ __('order.confirm')[$order->confirm] }}</span>
                                {{ convert_price($order->cart['cartTotal'] - $order->promotion['discount'], true) }}₫
                            </div>
                            <div
                                class="text_2">{{ array_column(__('payment.method'), 'title', 'name')[$order->method] ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="cancel-block">

                        @php
                            $deliveredStatuses = ['success'];  // trạng thái đã giao thành công
                            $processingStatuses = ['processing']; // trạng thái đang giao

                            $isDeliveredOrShipping = in_array($order->delivery, $deliveredStatuses) || in_array($order->delivery, $processingStatuses);
                            $isCancelled = $order->confirm === 'cancel';
                            $isPendingCancel = $order->confirm === 'pending_cancel';
                            $isPaid = $order->payment === 'paid';

                            // Chưa thanh toán và chưa giao (chưa trong trạng thái processing hay success)
                            $canCancelImmediately = !$isPaid && !$isDeliveredOrShipping && !$isCancelled;

                            // Đã thanh toán nhưng chưa giao, có thể hủy qua modal
                            $canCancelWithModal = $isPaid && !$isDeliveredOrShipping && !$isCancelled;
                        @endphp

                        @if ($canCancelImmediately)
                            <form action="{{ route('admin.order.confirm-cancel', [$order->id]) }}"
                                  method="POST"
                                  style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="cancel_reason"
                                       value="Hủy đơn ngay - chưa thanh toán và chưa giao">
                                <button type="submit" class="btn btn-dangers" style="">Hủy đơn hàng ngay</button>
                            </form>
                        @elseif ($canCancelWithModal)
                            <button type="button" class="btn btn-dangers" data-toggle="modal"
                                    data-target="#cancelOrderModal">
                                Hủy đơn hàng
                            </button>
                        @elseif ($isDeliveredOrShipping)
                            <span class="text-danger">Đơn hàng đang giao hoặc đã giao thành công - không thể huỷ</span>
                        @elseif ($isCancelled)
                            <button type="button" class="btn btn-secondary" disabled>
                                Đã hủy
                            </button>
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#cancelInfoModal" style="margin-left: 10px;">
                                Xem thông tin huỷ đơn
                            </button>
                        @elseif ($isPendingCancel)
                            <span class="text-warning">Yêu cầu huỷ đang chờ xác nhận</span>
                        @endif


                    </div>
                </div>
            </div>
            <div class="payment-confirm">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <div class="uk-flex uk-flex-middle">
                        <span class="icon"><i class="fa fa-truck"></i></span>
                        <div class="payment-title">
                            <div class="text_1">Xác nhận đơn hàng</div>
                        </div>
                    </div>
                    <div class="confirm-block">
                        @if($order->confirm == 'pending')
                            <button class="button confirm updateField" data-field="confirm" data-value="confirm"
                                    data-title="ĐÃ XÁC NHẬN ĐƠN HÀNG TRỊ GIÁ">Xác nhận
                            </button>
                        @else
                            Đã xác nhận
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 order-aside">
        <div class="ibox">
            <div class="ibox-title">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <span>Ghi chú</span>
                    <div class="edit span edit-order" data-target="description">Sửa</div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="description">
                    {{ $order->description }}
                </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-title">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <h5>Thông tin khách hàng</h5>
                    <div class="edit span edit-order" data-target="customerInfo">Sửa</div>
                </div>
            </div>
            <div class="ibox-content order-customer-information">
                <div class="customer-line">
                    <strong>Họ Tên:</strong>
                    <span class="fullname">{{ $order->fullname }}</span>
                </div>
                <div class="customer-line">
                    <strong>Email:</strong>
                    <span class="email">{{ $order->email }}</span>
                </div>
                <div class="customer-line">
                    <strong>Số điện thoại:</strong>
                    <span class="phone">{{ $order->phone }}</span>
                </div>
                <div class="customer-line">
                    <strong>Địa chỉ:</strong>
                    <span class="address">{{ $order->address }}</span>
                </div>
                <div class="customer-line">
                    <strong>Thành phố:</strong>
                    <span class="address"> {{ $order->ward_name }}</span>

                </div>
                <div class="customer-line">
                    <strong>Quận/Huyện:</strong>
                    <span class="address">{{ $order->district_name }}</span>

                </div>
                <div class="customer-line">
                    <strong>Phường xã:</strong>
                    <span class="address">  {{ $order->province_name }}</span>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-right mb15 fixed-bottom">
    <a class="btn btn-primary" href="http://127.0.0.1:8000/order/index">Quay lại</a>
</div>
</div>
<input type="hidden" class="orderId" value="{{ $order->id }}">
<input type="hidden" class="ward_id" value="{{ $order->ward_id }}">
<input type="hidden" class="district_id" value="{{ $order->district_id }}">
<input type="hidden" class="province_id" value="{{ $order->province_id }}">

<div class="modal fade  cancel-order-modal" id="cancelOrderModal" tabindex="-1" role="dialog"
     aria-labelledby="cancelOrderModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.order.confirm-cancel', $order->id) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Xác nhận hủy đơn hàng #{{ $order->code }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Lý do hủy lấy sẵn, có thể chỉnh -->
                <div class="form-group">
                    <label for="cancel_reason">Lý do hủy</label>
                    <textarea name="cancel_reason" id="cancel_reason" class="form-control"
                              readonly>{{ old('cancel_reason', $order->cancel_reason) }}</textarea>
                </div>

                <!-- Số tài khoản ngân hàng lấy sẵn, có thể chỉnh -->
                <div class="form-group">
                    <label for="account_owner">Tên chủ tài khoản</label>
                    <input type="text" name="account_owner" id="account_owner" class="form-control" readonly
                           value="{{ old('account_owner', $order->account_owner) }}">
                </div>

                <div class="form-group">
                    <label for="bank_account">Số tài khoản ngân hàng hoàn tiền</label>
                    <input type="text" name="bank_account" id="bank_account" class="form-control" readonly
                           value="{{ old('bank_account', $order->bank_account) }}">
                </div>

                <!-- Ảnh bill hoàn tiền mới upload -->
                <div class="form-group">
                    <label for="refund_bill">Ảnh bill hoàn tiền</label>
                    <input type="file" name="refund_bill" id="refund_bill" class="form-control-file"
                           accept="image/*">

                    <!-- Hiển thị ảnh bill hiện tại nếu có -->
                    @if(!empty($order->refund_bill))
                        <p class="mt-2">Ảnh bill hiện tại:</p>
                        <img src="{{ asset($order->refund_bill) }}" alt="Ảnh bill"
                             style="max-width: 200px; border:1px solid #ddd; margin-bottom: 10px;">
                    @endif

                    <!-- Ảnh xem trước khi upload ảnh mới -->
                    <img id="preview_refund_bill" src="#" alt="Ảnh xem trước"
                         style="max-width: 200px; display: none; margin-top: 10px; border:1px solid #ccc;"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xác nhận hủy đơn</button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('refund_bill').addEventListener('change', function () {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('preview_refund_bill');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>


@if($order->confirm == 'cancel')
    <div class="modal fade " id="cancelInfoModal" tabindex="-1" role="dialog" aria-labelledby="cancelInfoModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h2 class="modal-title" id="cancelInfoModalLabel">Thông tin huỷ đơn hàng #{{ $order->code }}</h2>

                </div>
                <div class="modal-body">
                    <p style="color: #0a0a0a"><strong>Lý do huỷ:</strong> {{ $order->cancel_reason }}</p>
                    <p style="color: #0a0a0a"><strong>Số tài khoản hoàn
                            tiền:</strong> {{ $order->bank_account?? "Không có!" }}</p>

                    @if(!empty($order->refund_bill))
                        <p><strong>Ảnh bill hoàn tiền:</strong></p>
                        <img src="{{ asset($order->refund_bill) }}" alt="Ảnh bill"
                             style="max-width: 50%; border: 1px solid #ccc;">
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
        @endif
    </div>
    <script>
        var provinces = @json($provinces->map(function($item){
        return [
            'id' => $item->code,
            'name' => $item->name
        ];
    })->values());

    </script>

    <script>
        document.getElementById('showCancelForm')?.addEventListener('click', function () {
            const form = document.getElementById('cancelOrderForm');
            if (form) {
                form.style.display = 'block';
                this.style.display = 'none'; // Ẩn nút sau khi đã hiện form
            }
        });
    </script>

    <style>
        /* Modal dialog */
        .modal-dialog {
            max-width: 500px;
            margin-top: 10%;
            border-radius: 10px;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Modal header */
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
            position: relative;
        }

        .modal-title {
            font-weight: 600;
            font-size: 2rem;
            color: #333;
            margin: 0;
        }

        /* Close button */
        .modal-header .close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: #aaa;
            opacity: 0.7;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: color 0.3s ease, opacity 0.3s ease;
        }

        .modal-header .close:hover {
            color: #dc3545; /* Bootstrap danger color */
            opacity: 1;
        }

        /* Modal body */
        .modal-body {
            padding: 20px;
            color: #444;
            font-size: 14px;
            background-color: #fff;
        }

        /* Form group spacing */
        .form-group {
            margin-bottom: 1rem;
        }

        /* Labels */
        .form-group label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Inputs and textarea */
        .form-control,
        .form-control-file {
            width: 100%;
            padding: 8px 12px;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .form-control:focus,
        .form-control-file:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
        }

        /* Preview image */
        #preview_refund_bill {
            display: block;
            margin-top: 10px;
            max-width: 200px;
            border-radius: 6px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* Modal footer */
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            text-align: right;
        }

        /* Buttons */
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-dangers {
            background-color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            color: black;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-dangers:hover {
            background-color: #1c84c6;
            color: black;
        }

    </style>


    <style>
        /* Wrapper flex cho modal-dialog */
        #cancelInfoModal .modal-dialog {
            max-width: 1000px; /* tăng chiều rộng tối đa */
            width: 95%; /* chiều rộng phần trăm theo viewport */
            height: auto; /* tự động cao theo nội dung */
            margin: auto; /* căn giữa ngang */
            display: flex;
            align-items: center; /* căn giữa dọc */
            min-height: 80vh; /* cao tối thiểu 80% chiều cao viewport */
        }

        #cancelInfoModal .modal-content {
            width: 100%;
            max-height: 80vh; /* giới hạn chiều cao modal */
            overflow-y: auto; /* scroll nếu nội dung vượt */
            border-radius: 12px;
            padding: 20px;
        }

        #cancelInfoModal .modal-content {

            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2c3e50;
            background: #fff;
        }

        #cancelInfoModal .modal-header {
            padding: 20px 30px;
            border-bottom: none;
            background-color: #f7f9fc;
            position: relative;
        }

        #cancelInfoModal .modal-title {
            font-weight: 700;
            font-size: 24px;
            color: #34495e;
            margin: 0;
        }

        #cancelInfoModal .close {
            position: absolute;
            top: 18px;
            right: 25px;
            font-size: 28px;
            font-weight: 700;
            color: #888;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        #cancelInfoModal .close:hover {
            color: #e74c3c;
        }

        #cancelInfoModal .modal-body {
            padding: 25px 30px;
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            background-color: #fff;
        }

        #cancelInfoModal .modal-body p {
            margin-bottom: 16px;
        }

        #cancelInfoModal .modal-body strong {
            color: #2c3e50;
        }

        #cancelInfoModal .modal-body img {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin-top: 12px;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            object-fit: contain;
        }

        #cancelInfoModal .modal-footer {

            border-top: none;
            padding: 15px 30px;
            display: flex;
            justify-content: flex-end;
        }

        #cancelInfoModal .btn-secondary {
            background-color: #3498db;
            border: none;
            padding: 6px 28px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            color: white;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        #cancelInfoModal .btn-secondary:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 576px) {
            #cancelInfoModal .modal-dialog {
                max-width: 90%;
                margin: 1.75rem auto;
            }

            #cancelInfoModal .modal-header,
            #cancelInfoModal .modal-body,
            #cancelInfoModal .modal-footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            #cancelInfoModal .modal-title {
                font-size: 20px;
            }

            #cancelInfoModal .modal-body {
                font-size: 14px;
            }
        }
    </style>


    <script>
        document.getElementById("refund_bill").addEventListener("change", function (e) {
            const preview = document.getElementById("preview_refund_bill");
            const file = e.target.files[0];
            if (file) {
                preview.style.display = "block";
                preview.src = URL.createObjectURL(file);
            } else {
                preview.style.display = "none";
                preview.src = "#";
            }
        });
    </script>
