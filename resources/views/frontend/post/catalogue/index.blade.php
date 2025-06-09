@extends('frontend.homepage.layout')
@section('content')
    <div class="post-catalogue page-wrapper intro-wrapper">

        @include('frontend.component.breadcrumb')
        <div class="uk-container uk-container-center">
            <div class="post-container">
                <h1 class="heading-1"><span>title </span></h1>

                <div class="uk-grid uk-grid-medium">

                    <div class="uk-width-medium-1-1 uk-width-large-1-3 mb20">
                        <div class="blog-item uk-clearfix">
                            <a href="" class="image img-cover"><img src="" alt=""></a>
                            <div class="info">
                                <h3 class="title"><a href="" title=""></a></h3>
                                <div class="description">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('frontend.component.pagination')
            </div>
        </div>

    </div>
@endsection

