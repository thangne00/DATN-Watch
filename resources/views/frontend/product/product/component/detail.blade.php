<div class="panel-body">
    <div class="uk-grid uk-grid-medium">
        <div class="uk-width-large-1-2">

            <div class="popup-gallery">
                <div class="swiper-container">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-wrapper big-pic">

                        <div class="swiper-slide" data-swiper-autoplay="2000">
                            <a href="" data-uk-lightbox="{group:'my-group'}"
                               class="image img-scaledown"><img src=""
                                                                alt=""></a>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-container-thumbs">
                    <div class="swiper-wrapper pic-list">

                        <div class="swiper-slide">
                            <span class="image img-scaledown"><img src="" alt=""></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="uk-width-large-1-2">
            <div class="popup-product">
                <h1 class="title product-main-title"><span>name</span>
                </h1>
                <div class="rating">
                    <div class="uk-flex uk-flex-middle">
                        <div class="author">Đánh giá:</div>
                        <div class="star-rating">
                            <div class="stars" style="--star-width: 8{{ rand(1, 9) }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="product-specs">
                    <div class="spec-row">Mã sản phẩm: <strong>code</strong></div>
                    <div class="spec-row">Tình Trạng: <strong>Còn hàng</strong></div>
                </div>

                <div class="uk-grid uk-grid-small">
                    <div class="uk-width-large-1-2">
                        <div class="a-left">
                            @include('frontend.product.product.component.variant')
                            <div class="quantity mt10">
                                <div class="uk-flex uk-flex-middle">
                                    <div class="quantitybox uk-flex uk-flex-middle">
                                        <div class="minus quantity-button">-</div>
                                        <input type="text" name="" value="1" class="quantity-text">
                                        <div class="plus quantity-button">+</div>
                                    </div>
                                    <div class="btn-group uk-flex uk-flex-middle">
                                        <div class="btn-item btn-1 addToCart">
                                            <a href="" title="">Mua ngay</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-item btn-1 addToCart mobile">
                                <a href="" title="">Mua ngay</a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="a-right">
                            <div class="mb20"><strong>Dịch vụ của chúng tôi</strong></div>
                            <div class="panel-body">
                                <div class="right-item">
                                    <div class="label">Cam kết bán hàng</div>
                                    <div class="desc">✅Chính hãng có thẻ bảo hành đầy đủ</div>
                                </div>
                                <div class="right-item">
                                    <div class="label">CHĂM SÓC KHÁCH HÀNG</div>
                                    <div class="desc">✅Tư vấn nhiệt tình, lịch sự, trung thực</div>
                                </div>
                                <div class="right-item">
                                    <div class="label">CHÍNH SÁCH GIAO HÀNG</div>
                                    <div class="desc">✅Đồng kiểm →Thử hàng →Hài lòng thanh toán</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="uk-grid uk-grid-medium">
        <div class="uk-width-large-3-4">
            <div class="product-wrapper">
                @include('frontend.product.product.component.general')
                @include('frontend.product.product.component.review')
            </div>
        </div>
        <div class="uk-width-large-1-4 uk-visible-large">
            <div class="aside">

                <div class="aside-category aside-product mt20">
                    <div class="aside-heading">Sản phẩm nổi bật</div>
                    <div class="aside-body">
                        <div class="aside-product uk-clearfix">
                            <a href="" class="image img-cover"><img src="" alt=""></a>
                            <div class="info">
                                <h3 class="title"><a href="" title="">name</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-related">
        <div class="uk-container uk-container-center">
            <div class="panel-product">
                <div class="main-heading">
                    <div class="panel-head">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <h2 class="heading-1"><span>Sản phẩm cùng danh mục</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-related">
        <div class="uk-container uk-container-center">
            <div class="panel-product">
                <div class="main-heading">
                    <div class="panel-head">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <h2 class="heading-1"><span>Sản phẩm đã xem</span></h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body list-product">

                    <div class="uk-grid uk-grid-medium">

                        <div
                            class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-5 mb20">

                            <div class="product-item product">
                                <a href="" class="image img-scaledown img-zoomin"><img
                                        src="" alt=""></a>
                                <div class="info">
                                    <h3 class="title">title</h3>
                                    <div class="price">
                                        <div class="price-sale">100vnd</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



