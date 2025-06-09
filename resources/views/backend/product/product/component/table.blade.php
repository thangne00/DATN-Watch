<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th style="width:50px;">
            <input type="checkbox" value="" class="input-checkbox">
        </th>
        <th style="width:700px;">title</th>
        @include('backend.dashboard.component.languageTh')
        <th style="width:80px;" class="text-center">title</th>
        <th class="text-center" style="width:100px;">title</th>
        <th class="text-center" style="width:100px;">title</th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td>
            <input type="checkbox" class="input-checkbox checkBoxItem">
        </td>
        <td>
            <div class="uk-flex uk-flex-middle">
                <div class="image mr5">
                    <div class="img-scaledown image-product"><img src="" alt="">
                    </div>
                </div>
                <div class="main-info">
                    <div class="name"><span class="maintitle">name</span></div>
                    <div class="catalogue">
                        <span class="text-danger">{{ __('messages.tableGroup') }} </span>

                        <a href="">name</a>

                    </div>

                </div>
            </div>
        </td>

        <td>
            <input type="text" name="" value=""
                   class="form-control sort-order text-right"
            >
        </td>
        <td class="text-center ">
            <input type="checkbox" value="" class="js-switch status "/>
        </td>
        <td class="text-center">
            <a href="" class="btn btn-success"><i
                    class="fa fa-edit"></i></a>
            <a href="" class="btn btn-danger"><i
                    class="fa fa-trash"></i></a>
        </td>
    </tr>

    </tbody>
</table>
