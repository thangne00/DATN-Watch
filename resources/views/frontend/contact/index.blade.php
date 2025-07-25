@extends('frontend.homepage.layout')
@section('content')

    <div class="contact-page">
        <div class="page-breadcrumb background">
            <div class="uk-container uk-container-center">
                <ul class="uk-list uk-clearfix">
                    <li><a href="" title="">Liên Hệ</a></li>

                </ul>
            </div>
        </div>
        <div class="uk-container uk-container-center">
            <div class="contact-container-1">
                <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                    <div class="uk-width-large-1-2">
                        <div class="contact-infor">
                            <span class="image"><img src="" alt=""></span>
                            <div class="brand mb10 mt10"></div>
                            <div class="footer-contact">
                                <p class="address">Văn Phòng : </p>
                                <p class="phone">Hotline: </p>
                                <p class="email">Email: ></p>
                            </div>

                        </div>

                    </div>
                    <div class="uk-width-large-1-2">
                        <form onsubmit="return false;" action="" method="post" class="uk-form form contact-form">
                            <div class="heading-form">Liên hệ ngay với chúng tôi để nhận tư vấn tốt Nhất</div>
                            <div class="uk-grid uk-grid-medium">
                                <div class="uk-width-large-1-2 mb20">
                                    <div class="form-row">
                                        <input
                                            type="text"
                                            name="fullname"
                                            class="input-text"
                                            placeholder="Tên của bạn"
                                        >
                                    </div>
                                </div>
                                <div class="uk-width-large-1-2 mb20">
                                    <div class="form-row">
                                        <input
                                            type="text"
                                            name="phone"
                                            class="input-text"
                                            placeholder="Số điện thoại của bạn"
                                        >
                                    </div>
                                </div>
                                <div class="uk-width-large-1-2 ">
                                    <div class="form-row">
                                        <input type="text" name="email" class="input-text" placeholder="Email của bạn">
                                    </div>
                                </div>
                                <div class="uk-width-large-1-2 ">
                                    <div class="form-row">
                                        <input type="text" name="phone" class="input-text" placeholder="Chủ đề">
                                    </div>
                                </div>
                            </div>
                            <textarea style="padding:10px;" name="" id="" placeholder="Nội dung" class=""></textarea>
                             <button type="submit" name="send" value="create">Liên Hệ Ngay</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

