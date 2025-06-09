@include('backend.dashboard.component.breadcrumb')
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>title </h5>
                @include('backend.dashboard.component.toolbox')
            </div>
            <div class="ibox-content">
                @include('backend.post.catalogue.component.filter')
                @include('backend.post.catalogue.component.table')
            </div>
        </div>
    </div>
</div>

