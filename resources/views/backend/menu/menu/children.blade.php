@include('backend.dashboard.component.breadcrumb')
@include('backend.dashboard.component.formError')

<form action="" method="post" class="box menuContainer">
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('backend.menu.menu.component.list')

        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit">Bảo vệ hé</button>
        </div>
    </div>
</form>

@include('backend.menu.menu.component.popup')