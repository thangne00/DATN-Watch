@extends('frontend.homepage.layout')
@section('content')
    <div class="cart-success">
        <div class="panel-head">
            <h2 class="cart-heading"><span>Đặt hàng thành công</span></h2>
            <div class="discover-text"><a href="{{ write_url('thuong-hieu') }}">Khám phá thêm các sản phẩm khác tại đây</a></div>
        </div>
        <div class="panel-body">
            <h2 class="cart-heading"><span>Thông tin đơn hàng</span></h2>
            <div class="checkout-box">
                <div class="checkout-box-head">
                    <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                        <div class="uk-width-large-1-3"></div>
                        <div class="uk-width-large-1-3">
                            <div class="order-title uk-text-center">ĐƠN HÀNG #{{ $order->code }}</div>
                        </div>
                        <div class="uk-width-large-1-3">
                            <div class="order-date">{{ convertDateTime($order->created_at); }}</div>
                        </div>
                    </div>
                </div>
                <div class="checkout-box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="uk-text-left">Tên sản phẩm</th>
                                <th class="uk-text-center">Số lượng</th>
                                <th class="uk-text-right">Giá niêm yết</th>
                                <th class="uk-text-right">Giá bán</th>
                                <th class="uk-text-right">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $carts = $order->products;
                            @endphp
                            @foreach($carts as $key => $val)
                            @php
                                $name = $val->pivot->name;
                                $qty = $val->pivot->qty;
                                $price = convert_price($val->pivot->price, true);
                                $priceOriginal = convert_price($val->pivot->priceOriginal, true);
                                $subtotal = convert_price($val->pivot->price * $qty, true);
                            @endphp
                            <tr>
                                <td class="uk-text-left">{{ $name }}</td>
                                <td class="uk-text-center">{{ $qty }}</td>
                                <td class="uk-text-right">{{ $priceOriginal }}đ</td>
                                <td class="uk-text-right">{{ $price }}đ</td>
                                <td class="uk-text-right"><strong>{{ $subtotal }}đ</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Mã giảm giá</td>
                                <td><strong>{{ $order->promotion['code'] }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4">Tổng giá trị sản phẩm</td>
                                <td><strong>{{ convert_price($order->cart['cartTotal'], true) }}đ</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4">Tổng giá trị khuyến mãi</td>
                                <td><strong>{{ convert_price($order->promotion['discount'], true) }}đ</strong></td>
                            </tr>
                            <tr>
                                <td colspan="4">Phí giao hàng</td>
                                <td><strong>0đ</strong></td>
                            </tr>
                            <tr class="total_payment">
                                <td colspan="4"><span>Tổng thanh toán</span></td>
                                <td>{{ convert_price($order->cart['cartTotal'] - $order->promotion['discount'], true) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-foot">
            <h2 class="cart-heading"><span>Thông tin nhận hàng</span></h2>
            <div class="checkout-box">
                <div>Tên người nhận: {{ $order->fullname }}<span></span></div>
                <!-- <div>Email: {{ $order->email }}<span></span></div> -->
                <div>Địa chỉ: {{ $order->address }}<span></span></div>
                @php
                    $province = $order->provinces->first()->name;
                    $district = $order->provinces->first()->districts->where('code',$order->district_id)->first()->name;
                    $ward =$order->provinces->first()->districts->where('code',$order->district_id)->first()->wards->where('code',$order->ward_id)->first()->name;
                @endphp
                <div>Phường/Xã: <span>{{ $ward }}</span>
                </div>
                <div>Quận/Huyện: <span>{{ $district }}</span></div>
                <div>Tỉnh/Thành phố: <span>{{ $province }}</span></div>
                <div>Số điện thoại: {{ $order->phone }}<span></span></div>
                <div>Hình thức thanh toán: {{ array_column(__('payment.method'), 'title', 'name')[$order->method] ?? '-' }}<span></span></div>

                @if(isset($template))
                    @include($template)
                @endif

            </div>
        </div>
    </div>

    <div class="cart-container">
    <div class="page-breadcrumb background">      
        <div class="uk-container uk-container-center">
            <ul class="uk-list uk-clearfix">
                <li><a href="/"><i class="fi-rs-home mr5"></i>Trang chủ</a></li>
                <li><a href="http://127.0.0.1:8000/thanh-toan.html" title="Hệ thống phân phối">Thanh toán</a></li>
            </ul>
        </div>
    </div>
    <div class="uk-container uk-container-center">

        @if ($errors->any())
        <div class="uk-alert uk-alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('cart.store') }}" class="uk-form form" method="post">
            @csrf
            <h2 class="heading-1"><span>Thông tin đặt hàng</span></h2>
            <div class="cart-wrapper">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-2-5">
                        <div class="panel-cart cart-left">
                            @include('frontend.cart.component.information')
                            @include('frontend.cart.component.method')
                        </div>
                    </div>
                    <div class="uk-width-large-3-5">
                        <div class="panel-cart">
                            <div class="panel-head">
                                <h2 class="cart-heading"><span>Đơn hàng</span></h2>
                            </div>
                            @include('frontend.cart.component.item')
                            @include('frontend.cart.component.voucher')
                            @include('frontend.cart.component.summary')
                            <button type="submit" class="cart-checkout" value="create" name="create">Thanh toán đơn hàng</button>
                            <div class="box-info mt-3">
                                <div class="box-title">Thông tin bổ sung</div>
                                <div class="info">
                                    <div class="content-style">
                                        <h3><strong>Chính sách trả hàng, đổi hàng:</strong></h3>
                                        <p>Ngoại trừ lỗi do nhà sản xuất hoặc khác mẫu yêu cầu, những trường hợp còn lại Quý khách không được đổi-trả hàng.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


