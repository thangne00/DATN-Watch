@include('backend.dashboard.component.breadcrumb')

<form action="" method="" class="box">

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>messages</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content')
                    </div>
                </div>
               @include('backend.dashboard.component.album')
               @include('backend.dashboard.component.seo')
            </div>
            <div class="col-lg-3">
                @include('backend.post.post.component.aside')
            </div>
        </div>
        @include('backend.dashboard.component.button')
    </div>
</form>
