<div class="ibox w">
    <div class="ibox-title">
        <h5>Title</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <select class="form-control setupSelect2" id="">
                        <option>##</option>
                        <option>##</option>
                        <option>##</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">title</label>
                    <select multiple name="catalogue[]" class="form-control setupSelect2" id="">
                        <option>###</option>
                        <option>###</option>
                        <option>###</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>title</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">title</label>
                    <input
                        type="text"
                        name="code"
                        class="form-control"
                    >
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">title</label>
                    <input
                        type="text"
                        name="made_in"
                        class="form-control "
                    >
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">title</label>
                    <input
                        type="text"
                        name="price"
                        class="form-control int"
                    >
                </div>
            </div>
        </div>
        <div class="form-row mb20">
            <label for="" class="control-label text-left">Thời gian BH</label>
            <div class="">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <input
                        type="text"
                        name=""
                        class="text-right form-control int"
                        placeholder=""
                        autocomplete="off"
                        style="margin-right:10px;"
                    >
                    <select class="setupSelect2" name="" id="">
                        <option value="month">tháng</option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>
@include('backend.dashboard.component.publish')


