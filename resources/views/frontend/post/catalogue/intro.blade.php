@extends('frontend.homepage.layout')
@section('content')
    <div class="post-catalogue page-wrapper intro-wrapper">
        <span class="image img-cover"><img src="" alt=""></span>

        @include('frontend.component.breadcrumb')
        <div class="uk-container uk-container-center">
            <div class="panel-body">
               <div class="sub-heading">Xin Chào!</div>
               <h1 class="cat-heading">Chào mừng đến với <strong>Omega</strong> <span>Deco</span></h1>
               <div class="description">

               </div>
            </div>

        </div>

            <div class="panel-value">
                <div class="uk-container uk-container-center">
                    <div class="panel-head">
                        <div class="welcome">Giá trị cốt lõi</div>
                        <div class="title">mà <strong>Omega Deco</strong> hướng tới</div>
                        <div class="notice">Giá trị cốt lõi của công ty chúng tôi thông qua 3 yếu tố để đem lại sự hài lòng cho khách hàng</div>
                    </div>
                    <div class="panel-body">

                        <div class="uk-grid uk-grid-large">

                            <div class="uk-width-small-1-1 uk-width-medium-1-3">
                                <div class="value-item">
                                    <span class="text">Giá trị</span>

                                    <div class="title"></div>
                                    <div class="title"></div>
                                    <div class="title"></div>
                                    <div class="description">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="panel-staff page">
                <div class="uk-container uk-container-center">
                    <div class="panel-head">
                        <h2 class="heading-1"><span></span></h2>
                        <div class="description"></div>
                    </div>
                    <div class="panel-body">

                        <div class="uk-grid uk-grid-medium">

                            <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 mb20 wow fadeInLeft" data-wow-delay="0.{{ $keyPost + 1 }}s">
                                <div class="staff-item">
                                    <span class="image img-scaledown"><img src="" alt=""></span>
                                    <div class="info">
                                        <div class="title"></div>
                                        <div class="description"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </div>
@endsection

