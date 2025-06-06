@extends('frontend.homepage.layout')
@section('content')
    <div class="post-catalogue page-wrapper intro-wrapper">

        <span class="image img-cover"><img src="" alt=""></span>

        @include('frontend.component.breadcrumb')
        <div class="uk-container uk-container-center">
            <div class="project-container">
                <h1 class="heading-6"><span></span></h1>
                <div class="project-list">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-medium-1-2 uk-width-large-1-3 mb20">
                            <div class="project-item-1">
                                <a href="" class="image img-cover"><img src="" alt=""></a>
                                <div class="info">
                                    <h3 class="title"><a href="" title="}">title</a></h3>
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

    </div>
@endsection

