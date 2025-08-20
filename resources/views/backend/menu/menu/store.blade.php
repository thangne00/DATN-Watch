@include('backend.dashboard.component.breadcrumb')
@include('backend.dashboard.component.formError')

<form action="" method="post" class="box menuContainer">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('backend.menu.menu.component.catalogue')
        <hr>
        @include('backend.menu.menu.component.list')

        <input type="hidden" name="redirect">
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại </button>
        </div>
    </div>

</form>

@include('backend.menu.menu.component.popup')