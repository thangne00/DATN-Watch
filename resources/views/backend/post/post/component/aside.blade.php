<div class="ibox w">
    <div class="ibox-title">
        <h5>messages</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <select name="post_catalogue_id" class="form-control setupSelect2" id="">
                        <option value="">#1</option>
                        <option value="">#1</option>
                        <option value="">#1</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">{{ __('messages.subparent') }}</label>
                    <select multiple name="catalogue[]" class="form-control setupSelect2" id="">
                        <option
                            value="">#1
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">

        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <h5>Video Clip</h5>
            <a href="" class="upload-video">Upload Video</a>
        </div>

    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <textarea name="video" class="form-control video-target"
                              style="height:168px;"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@include('backend.dashboard.component.publish')
