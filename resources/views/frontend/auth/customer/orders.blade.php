@extends('frontend.homepage.layout')
@section('content')
    <style>
        .profile-container {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 30px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .order-table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        .table-order {
            width: 100%;
            border-collapse: collapse;
        }

        .table-order thead {
            background-color: #343a40;
            color: #fff;
        }

        .table-order th,
        .table-order td {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid #eaeaea;
            font-size: 14px;
        }

        .table-order tbody tr:hover {
            background-color: #f1f7ff;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-view {
            background-color: #17a2b8;
            color: #fff;
        }

        .btn-view:hover {
            background-color: #138496;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .btn-cancel:hover {
            background-color: #bd2130;
        }

        @media (max-width: 768px) {
            .table-order thead {
                display: none;
            }

            .table-order tbody tr {
                display: block;
                margin-bottom: 15px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                padding: 10px;
            }

            .table-order td {
                display: flex;
                justify-content: space-between;
                padding: 8px 14px;
                font-size: 14px;
                border-bottom: 1px solid #eee;
            }

            .table-order td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #333;
                flex: 1;
                text-align: left;
            }

            .table-order td:last-child {
                border-bottom: none;
            }
        }
    </style>

    <div class="profile-container">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-1-4">
                    @include('frontend.auth.customer.components.sidebar')
                </div>
                <div class="uk-width-large-3-4">
                    <div class="order-table-container">
                        <h2 style="margin-bottom: 20px; font-weight: 600;">Lịch sử đơn hàng</h2>
                        <table class="table-order">
                            <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Giao hàng</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td data-label="Mã đơn">#{{ $order->code }}</td>
                                    <td data-label="Ngày đặt">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td data-label="Trạng thái">{{ __('cart.confirm')[$order->confirm] ?? '-' }}</td>
                                    <td data-label="Thanh toán">{{ __('cart.payment')[$order->payment] ?? '-' }}</td>
                                    <td data-label="Giao hàng">{{ __('cart.delivery')[$order->delivery] ?? '-' }}</td>
                                    <td data-label="Tổng tiền">{{ number_format($order->cart['cartTotal'], 0, ',', '.') }}
                                        ₫
                                    </td>
                                    <td data-label="Hành động">
                                        <a href="{{ route('customer.order.detail', ['code' => $order->code]) }}"
                                           class="btn-action btn-view">
                                            <i class="fa fa-eye"></i> Xem chi tiết
                                        </a>
                                        {{--                                        @if($order->payment === 'paid' && $order->delivery === 'success')--}}
                                        {{--                                            <a href=""--}}
                                        {{--                                               class="btn-action btn-review">--}}
                                        {{--                                                <i class="fa fa-star"></i> Đánh giá--}}
                                        {{--                                            </a>--}}
                                        {{--                                        @endif--}}

                                        @if($order->confirm == 'confirm' && $order->payment != 'paid' && $order->delivery != 'processing')
                                            <button class="btn-action btn-cancel" data-toggle="modal"
                                                    data-target="#cancelOrderModal{{ $order->id }}">
                                                <i class="fa fa-times-circle"></i> Hủy
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($orders->isEmpty())
                            <p class="text-center mt-4">Bạn chưa có đơn hàng nào.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
