@extends('frontend.homepage.layout')
@section('content')

<div class="post-detail">

    @include('frontend.component.breadcrumb')
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium">
            <div class="uk-width-large-3-4">
                <div class="detail-wrapper">
                    <h1 class="post-title">name</h1>
                    <div class="description">

                    </div>
                    <div class="content">

                    </div>
                </div>
            </div>
            <div class="uk-width-large-1-4">
                @include('frontend.component.post-aside')
            </div>
        </div>
    </div>
</div>

@endsection
