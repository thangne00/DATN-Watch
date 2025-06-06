<div id="header" class="pc-header uk-visible-large">
    <div class="upper">
        <div class="uk-container uk-container-center">
            <div class="company-name">title</div>
        </div>
    </div>
    <div class="middle">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="logo">
                    <a href="/"><img src="title" alt="Logo"></a>
                </div>
                <div class="header-search">
                    <form action="" class="uk-form form">
                        <input type="text" name="keyword" value="" class="input-text">
                        <button type="submit" value="" name="">
                            Tìm kiếm <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="header-toolbox">
                    <div class="uk-flex uk-flex-middle">
                        <div class="header-cart">
                            <div class="uk-flex uk-flex-middle">
                                <a href="" class="cart-text">Giỏ Hàng</a>
                                <div class="cart-mini">
                                    <span class="number">0</span>
                                    <img src="frontend/resources/img/shopping-cart.png" alt="cart image">
                                </div>
                            </div>
                        </div>
                        <div class="header-hotline">
                            <div class="text">Hotline</div>
                            <div class="hotline-number">{{ $system['contact_hotline'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="lower" data-uk-sticky>
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                <div class="uk-width-large-1-5">

                    <div class="logoScroll">
                        <a href="" class="image img-cover"><img src="" alt=""></a>
                    </div>
                    <div class="categories">
                        <div class="category-heading">Danh mục sản phẩm</div>
                        <div class="category-dropdown">
                            <ul class="uk-list uk-clearfix">
                                <li><a href="" title=""> </a></li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="uk-width-large-4-5">
                    @include('frontend.component.navigation')
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mobile-header uk-hidden-large">
    <div class="mobile-upper">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="mobile-logo">
                    <a href="." title="">
                        <img src="" alt="Mobile Logo">
                    </a>
                </div>
                <div class="mobile-widget">
                    <div class="uk-flex uk-flex-middle">
                        <a href="" class="btn btn-addCart">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="M24.4941 3.36652H4.73614L4.69414 3.01552C4.60819 2.28593 4.25753 1.61325 3.70863 1.12499C3.15974 0.636739 2.45077 0.366858 1.71614 0.366516L0.494141 0.366516V2.36652H1.71614C1.96107 2.36655 2.19748 2.45647 2.38051 2.61923C2.56355 2.78199 2.68048 3.00626 2.70914 3.24952L4.29414 16.7175C4.38009 17.4471 4.73076 18.1198 5.27965 18.608C5.82855 19.0963 6.53751 19.3662 7.27214 19.3665H20.4941V17.3665H7.27214C7.02705 17.3665 6.79052 17.2764 6.60747 17.1134C6.42441 16.9505 6.30757 16.7259 6.27914 16.4825L6.14814 15.3665H22.3301L24.4941 3.36652ZM20.6581 13.3665H5.91314L4.97214 5.36652H22.1011L20.6581 13.3665Z"
                                        fill="#253D4E"></path>
                                    <path
                                        d="M7.49414 24.3665C8.59871 24.3665 9.49414 23.4711 9.49414 22.3665C9.49414 21.2619 8.59871 20.3665 7.49414 20.3665C6.38957 20.3665 5.49414 21.2619 5.49414 22.3665C5.49414 23.4711 6.38957 24.3665 7.49414 24.3665Z"
                                        fill="#253D4E"></path>
                                    <path
                                        d="M17.4941 24.3665C18.5987 24.3665 19.4941 23.4711 19.4941 22.3665C19.4941 21.2619 18.5987 20.3665 17.4941 20.3665C16.3896 20.3665 15.4941 21.2619 15.4941 22.3665C15.4941 23.4711 16.3896 24.3665 17.4941 24.3665Z"
                                        fill="#253D4E"></path>
                                </g>
                                <defs>
                                    <clipPath>
                                        <rect width="24" height="24" fill="white"
                                              transform="translate(0.494141 0.366516)"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                        <a href="#mobileCanvas" class="mobile-menu-button" data-uk-offcanvas>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="100%" height="100%" preserveAspectRatio="none"
                                 viewBox="0 0 1536 1896.0833" class="" fill="rgb(218,34,41)">
                                <path
                                    d="M1536 1344v128q0 26-19 45t-45 19H64q-26 0-45-19t-19-45v-128q0-26 19-45t45-19h1408q26 0 45 19t19 45zm0-512v128q0 26-19 45t-45 19H64q-26 0-45-19T0 960V832q0-26 19-45t45-19h1408q26 0 45 19t19 45zm0-512v128q0 26-19 45t-45 19H64q-26 0-45-19T0 448V320q0-26 19-45t45-19h1408q26 0 45 19t19 45z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-mobile">
        <form action="" class="uk-form form mobile-form">
            <div class="form-row">
                <input type="text" name="keyword" value="" class="input-text" placeholder="Từ khóa tìm kiếm...">
                <button name="btn-search" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
</div>
