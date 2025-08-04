@extends('frontend.homepage.layout')
@section('content')
    <style>
        .container {
            background-color: #f8f9fa;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            font-family: Arial, sans-serif;
        }

        /* Tiêu đề chính */
        .container h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        /* Thông tin đơn hàng */
        .container p {
            font-size: 15px;
            color: #444;
            margin-bottom: 8px;
        }

        /* Tiêu đề phụ */
        .container h4 {
            font-size: 18px;
            font-weight: 600;
            margin-top: 30px;
            margin-bottom: 10px;
            color: #222;
        }

        /* Bảng sản phẩm */
        .table {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead {
            background-color: #007bff;
            color: #fff;
        }

        .table th, .table td {
            vertical-align: middle !important;
            font-size: 14px;
            text-align: center;
            padding: 12px;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f6ff;
        }

        /* Tổng tiền */
        .container p strong {
            font-size: 16px;
            color: #000;
        }

        /* Nút */
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .btn-success {
            background-color: #5aaf41;
            color: #fff;
            border: none;
        }

        .btn-danger {
            background-color: #f05b4f;
            color: #fff;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: scale(1.03);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .table th, .table td {
                font-size: 13px;
                padding: 8px;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>

    <div class="profile-container pt20 pb20">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-1-4">
                    @include('frontend.auth.customer.components.sidebar')
                </div>
                <div class=" uk-width-large-2-3 container py-5">
                    <h2>Chi tiết đơn hàng #{{ $order->code }}</h2>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Trạng thái:</strong> {{ __('cart.delivery')[$order->delivery] ?? 'Không xác định' }}</p>
                    <p><strong>Thanh toán:</strong> {{ __('cart.payment')[$order->payment] ?? 'Không xác định' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>

                    <h4 class="mt-4">Danh sách sản phẩm:</h4>
                    <table class="table table-bordered mt-2">
                        <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products as $item)
                            @php
                                $canonical = optional($item->languages->first())->pivot->canonical;
                            @endphp
                            <tr>
                                <td> @if($canonical)
                                        <a href="{{ route('router.index', ['canonical' => $canonical]) }}">
                                            {{ $item->pivot->name }}
                                        </a>
                                    @else
                                        {{ $item->pivot->name }}
                                    @endif</td>
                                <td>{{ number_format($item->pivot->price) }}đ</td>
                                <td>{{ $item->pivot->qty }}</td>
                                <td>{{ number_format($item->pivot->price * $item->pivot->qty) }}đ</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <p class="mt-3"><strong>Tổng
                            tiền:</strong> {{ number_format($order->cart['cartTotal'], 0, ',', '.') }}₫</p>
                    <br>
                    <a href="{{ route('customer.order') }}" class="btn btn-secondary mt-3">← Quay lại</a>
                    <!-- Button trigger modal -->
                    <!-- Nút bật modal -->
                    @if($order->payment == 'paid' && in_array($order->delivery, [ 'success']))
                        <button class="btn btn-success mt-3" disabled>Đơn hàng đã hoàn tất
                        </button>

                        @if($order->payment === 'paid' && $order->delivery === 'success')
                            @if($canonical)
                                <a href="{{ route('router.index', ['canonical' => $canonical]) }}"
                                   class="btn  btn-danger">
                                    <i class="fa fa-star"></i> Đánh giá
                                </a>
                            @endif
                        @endif
                    @elseif($order->payment == 'paid' && in_array($order->delivery, ['processing']))
                        <button class="btn btn-success mt-3" disabled>Đơn hàng đang trong quá trình giao
                        </button>
                    @elseif($order->confirm == 'cancel')
                        <button class="btn btn-secondary mt-3" disabled>Đơn hàng đã được hủy</button>
                    @elseif($order->confirm == 'pending_cancel')
                        <button class="btn btn-warning mt-3" disabled>Đang tiến hành xử lý</button>
                    @else
                        <button id="openCancelModalBtn" class="btn btn-danger mt-3">Yêu cầu hủy đơn hàng</button>
                    @endif




                    <!-- Modal -->
                    <div id="cancelOrderModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
  background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
                        <div style="background:#fff; padding:20px; width:400px; border-radius:8px; position:relative;">
                            <h3>Yêu cầu hủy đơn hàng #{{ $order->code }}</h3>

                            <form action="{{ route('customer.order.cancel', ['code' => $order->code]) }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div style="margin-bottom:10px;">
                                    <label for="cancel_reason">Lý do hủy:</label><br>
                                    <select name="cancel_reason" id="cancel_reason" required
                                            style="width: 100%; height: 40px;">
                                        <option value="">-- Chọn lý do hủy --</option>
                                        <option value="Tôi muốn thay đổi sản phẩm">Tôi muốn thay đổi sản phẩm</option>
                                        <option value="Đặt nhầm đơn">Đặt nhầm đơn</option>
                                        <option value="Tìm được giá tốt hơn">Tìm được giá tốt hơn</option>
                                        <option value="Không còn nhu cầu">Không còn nhu cầu</option>
                                        <option value="Khác">Khác</option>
                                    </select>

                                    <div id="custom-reason-box" style="display:none; margin-top: 10px;">
                                        <input type="text" name="custom_reason" placeholder="Nhập lý do khác..."
                                               class="input-text" style="width:100%">
                                    </div>
                                    <script>
                                        document.getElementById('cancel_reason').addEventListener('change', function () {
                                            const customBox = document.getElementById('custom-reason-box');
                                            if (this.value === 'Khác') {
                                                customBox.style.display = 'block';
                                            } else {
                                                customBox.style.display = 'none';
                                            }
                                        });
                                    </script>

                                </div>


                                @if ($order->payment == 'paid')
                                    <div style="margin-bottom:10px;">
                                        <label for="account_owner">Tên chủ tài khoảnn:</label><br>
                                        <input type="text" name="account_owner" id="account_owner" required
                                               style="width:100%;"/>
                                    </div>
                                    <div style="margin-bottom:10px;">
                                        <label for="bank_account">Số tài khoản nhận hoàn tiền:</label><br>
                                        <input type="text" name="bank_account" id="bank_account" required
                                               style="width:100%;"/>
                                    </div>
                                @endif

                                <div style="text-align:right;">
                                    <button type="button" id="cancelModalCloseBtn" style="margin-right:10px;">Đóng
                                    </button>
                                    <button type="submit"
                                            style="background:#d9534f; color:#fff; border:none; padding:8px 15px;">
                                        Gửi
                                        yêu cầu
                                    </button>
                                </div>
                            </form>
                        </div>


                    </div>
                </div>

                <script>
                    const modal = document.getElementById('cancelOrderModal');
                    const openBtn = document.getElementById('openCancelModalBtn');
                    const closeBtn = document.getElementById('cancelModalCloseBtn');

                    openBtn.addEventListener('click', () => {
                        modal.style.display = 'flex';
                    });

                    closeBtn.addEventListener('click', () => {
                        modal.style.display = 'none';
                    });

                    // Bấm ngoài modal đóng
                    window.addEventListener('click', (e) => {
                        if (e.target === modal) {
                            modal.style.display = 'none';
                        }
                    });
                </script>

            </div>
        </div>
    </div>
    </div>
    <style>
        #cancelOrderModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;

            /* Dùng flex để căn giữa nội dung modal */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #cancelOrderModal > div {
            background: #fff;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            max-width: 90%;
        }

        #cancelOrderModal h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-weight: 600;
            font-size: 1.4rem;
        }

        #cancelOrderModal label {
            font-weight: 500;
            margin-bottom: 5px;
            display: inline-block;
        }

        #cancelOrderModal textarea,
        #cancelOrderModal input[type="text"],
        #cancelOrderModal input[type="file"] {
            width: 100%;
            box-sizing: border-box;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            font-family: inherit;
        }

        #cancelOrderModal button[type="submit"] {
            background: #d9534f;
            color: #fff;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
        }

        #cancelOrderModal button[type="submit"]:hover {
            background: #c9302c;
        }

        #cancelOrderModal button#cancelModalCloseBtn {
            background: #eee;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
        }

        #cancelOrderModal button#cancelModalCloseBtn:hover {
            background: #ddd;
        }

    </style>
@endsection



