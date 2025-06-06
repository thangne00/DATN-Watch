@include('backend.dashboard.component.breadcrumb')
@include('backend.dashboard.component.formError')
<form action="" method="post" class="box">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Title</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content')
                    </div>
                </div>
                @include('backend.dashboard.component.album')
                @include('backend.product.product.component.variant')
            </div>
            <div class="col-lg-3">
                @include('backend.product.product.component.aside')
            </div>
        </div>
        @include('backend.dashboard.component.button')
    </div>
</form>
