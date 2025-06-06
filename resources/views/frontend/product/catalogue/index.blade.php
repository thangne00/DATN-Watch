@extends('frontend.homepage.layout')
@section('content')
    <div class="product-catalogue page-wrapper">
        @include('frontend.component.breadcrumb')
        <div class="uk-container uk-container-center mt20">

            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-1-4 uk-hidden-small">
                        <div class="aside">

                            <div class="aside-category">
                                <div class="aside-heading">Danh mục sản phẩm</div>
                                <div class="aside-body">
                                    <ul class="uk-list uk-clearfix">
                                        <li><a href="" title="}">danh mục</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="aside-category aside-product mt20">
                                <div class="aside-heading">Sản phẩm nổi bật</div>
                                <div class="aside-body">
                                    <div class="aside-product uk-clearfix">
                                        <a href="" class="image img-cover"><img src=""
                                                                                alt=""></a>
                                        <div class="info">
                                            <h3 class="title"><a href=""
                                                                 title="">title</a></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-3-4">
                        <div class="wrapper ">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                                <h1 class="heading-2">
                                    <span>title</span></h1>
                                @include('frontend.product.catalogue.component.filter')
                            </div>
                            @include('frontend.product.catalogue.component.filterContent')

                            <div class="product-list">
                                <div class="uk-grid uk-grid-medium">
                                    <div
                                        class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 mb20">
                                        @include('frontend.component.product-item')
                                    </div>

                                </div>
                            </div>

                            <div class="uk-flex uk-flex-center">
                                @include('frontend.component.pagination')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

