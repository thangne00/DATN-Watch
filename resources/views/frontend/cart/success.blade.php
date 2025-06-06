@extends('frontend.homepage.layout')
@section('content')
    <div class="cart-success">
        <div class="panel-head">
            <h2 class="cart-heading"><span>Đặt hàng thành công</span></h2>
            <div class="discover-text"><a href="">Khám phá thêm các sản phẩm khác tại đây</a></div>
        </div>
        <div class="panel-body">
            <h2 class="cart-heading"><span>Thông tin đơn hàng</span></h2>
            <div class="checkout-box">
                <div class="checkout-box-head">
                    <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                        <div class="uk-width-large-1-3"></div>
                        <div class="uk-width-large-1-3">
                            <div class="order-title uk-text-center">ĐƠN HÀNG #</div>
                        </div>
                        <div class="uk-width-large-1-3">
                            <div class="order-date"></div>
                        </div>
                    </div>
                </div>
                <div class="checkout-box-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="uk-text-left">Thông tin </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="uk-text-left">name</td>

                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Mã giảm giá</td>
                                <td><strong>code</strong></td>
                            </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-foot">
            <h2 class="cart-heading"><span>Thông tin nhận hàng</span></h2>
            <div class="checkout-box">
{{--   thông tin--}}
            </div>
        </div>
    </div>
@endsection


