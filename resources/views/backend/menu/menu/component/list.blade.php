<div class="row">
    <div class="col-lg-4">
        <div class="ibox">
            <div class="ibox-content">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                   aria-expanded="true" class="">Liên kết tự tạo</a>
                            </h5>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse " aria-expanded="true" style="">
                            <div class="panel-body">
                                <div class="panel-title">Tạo Menu</div>
                                <div class="panel-description">
                                    <p>+ Cài đặt Menu mà bạn muốn hiển thị.</p>
                                    <p><small class="text-danger">* Khi khởi tạo menu bạn phải chắc chắn rằng đường dẫn
                                            của menu có hoạt động. Đường dẫn trên website được khởi tạo tại các module:
                                            Bài viết, Sản phẩm, Dự án, ...</small></p>
                                    <p><small class="text-danger">* Tiêu đề và đường dẫn của menu không được bỏ
                                            trống.</small></p>
                                    <p><small class="text-danger">* Hệ Thống chỉ hỗ trợ tối đa 5 cấp menu.</small></p>
                                    <a style="color:#000;border-color:#c4cdd5;display:inline-block !important;" href=""
                                       title="" class="btn btn-default add-menu m-b m-r right">Thêm đường dẫn</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="text-bold" for="">Tên Menu</div>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-bold" for="">Đường dẫn</div>
                    </div>
                    <div class="col-lg-2">
                        <div class="text-bold" for="">Vị trí</div>
                    </div>
                    <div class="col-lg-2 text-center">
                        <div class="text-bold" for="" class="">Xóa</div>
                    </div>
                </div>
                <div class="hr-line-dashed" style="margin:10px 0;"></div>

                <div class="menu-wrapper">
                    <div class="notification text-center ">
                        <h4 style="font-weight:500;font-size:16px;color:#000">Danh sách liên kết này chưa có bất kì
                            đường dẫn nào.</h4>
                        <p style="color:#555;margin-top:10px;">Hãy nhấn vào <span
                                style="color:blue;">"Thêm đường dẫn"</span> để băt đầu thêm.</p>
                    </div>
                    )
                    <div class="row mb10 menu-item menu-item uk-flex uk-flex-middle">
                        <div class="col-lg-4">
                            <input
                                type="text"
                                value="{{ $val }}"
                                class="form-control"
                                name="menu[name][]"
                            >
                        </div>
                        <div class="col-lg-4">
                            <input
                                type="text"
                                value="{{  $menu['canonical'][$key] }}"
                                class="form-control"
                                name="menu[canonical][]"
                            >
                        </div>
                        <div class="col-lg-2">
                            <input
                                type="text"
                                class="form-control int text-right"
                            >
                        </div>
                        <div class="col-lg-2">
                            <div class="form-row text-center">
                                <a class="delete-menu"><img
                                        src="backend/close.png"></a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
