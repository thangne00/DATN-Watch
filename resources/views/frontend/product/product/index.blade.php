@extends('frontend.homepage.layout')
@section('content')

    <div class="product-container">
        @include('frontend.component.breadcrumb')
        <div class="uk-container uk-container-center mt30">
            <div class="panel-body">
                @include('frontend.product.product.component.detail')
            </div>
        </div>
    </div>
   
@endsection
