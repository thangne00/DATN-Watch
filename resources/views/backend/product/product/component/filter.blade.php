<form action="">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            @include('backend.dashboard.component.perpage')
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    @include('backend.dashboard.component.filterPublish')

                    <select name="product_catalogue_id" class="form-control setupSelect2 ml10">
                        <option>#1</option>
                        <option>#1</option>
                        <option>#1</option>
                    </select>
                    @include('backend.dashboard.component.keyword')
                    <a href="" class="btn btn-danger"><i
                            class="fa fa-plus mr5"></i>title</a>
                </div>
            </div>
        </div>
    </div>
</form>

