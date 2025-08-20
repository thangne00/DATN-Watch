@include('backend.dashboard.component.breadcrumb')

<form action="" method="post" class="box">

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung nè</div>
                    <div class="panel-description">
                        <p>Bạn chắc chắn muốn xóa </p>
                        <p>Lưu ý: Không thể khôi phục sau khi xóa. Hãy chắc chắn bạnthực hiện chức năng
                            này</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Vị trí <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" class="form-control" placeholder="" autocomplete="off" readonly>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right mb15">
            <button class="btn btn-danger" type="submit" name="send" value="send">Xóa dữ liệu</button>
        </div>
    </div>
</form>
