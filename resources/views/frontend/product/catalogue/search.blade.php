@extends('frontend.homepage.layout')
@section('content')
    <div class="product-catalogue page-wrapper">
        <div class="uk-container uk-container-center mt20">

            <div class="panel-body">
                <h2 class="heading-1 mb20"><span>title</span></h2>
                <div class="product-list">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-5 mb20">
                            @include('frontend.component.product-item')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

