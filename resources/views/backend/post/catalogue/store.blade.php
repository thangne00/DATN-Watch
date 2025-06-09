@include('backend.dashboard.component.breadcrumb')
@include('backend.dashboard.component.formError')

<form action="" method="" class="box">

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>title</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content')
                    </div>
                </div>
               @include('backend.dashboard.component.album')
               @include('backend.dashboard.component.seo')
            </div>
            <div class="col-lg-3">
                @include('backend.post.catalogue.component.aside')
            </div>
        </div>
        @include('backend.dashboard.component.button')
    </div>
</form>
