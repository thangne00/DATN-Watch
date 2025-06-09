<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th style="width:50px;">
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
        </th>
        <th>title</th>
        @include('backend.dashboard.component.languageTh')
        <th style="width:80px;" class="text-center">1</th>
        <th class="text-center" style="width:100px;">2</th>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td>
            <input type="checkbox" class="input-checkbox checkBoxItem">
        </td>
        <td>
            <div class="uk-flex uk-flex-middle">
                <div class="main-info">
                    <div class="name"><span class="maintitle">title</span></div>
                    <div class="catalogue">
                        <span class="text-danger">{{ __('messages.tableGroup') }} </span>
                        <a href="">##</a>
                    </div>

                </div>
            </div>
        </td>
        @include('backend.dashboard.component.languageTd')
        <td>
            <input type="text"
                   class="form-control sort-order text-right"
            >
        </td>
        <td class="text-center">
            <input type="checkbox" class="js-switch status "/>
        </td>

    </tr>

    </tbody>
</table>
