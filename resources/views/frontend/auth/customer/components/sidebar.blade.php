<aside class="profile-sidebar">
    <div class="aside-task aside-panel">
        <ul class="uk-list uk-clearfix">
            <li><a href="{{ route('customer.profile') }}" class="{{ request()->routeIs('customer.profile') ? 'active' : '' }}" ><i class="fa fa-user"></i>Tài khoản của tôi</a></li>
            <li><a href="{{ route('customer.password.change') }}"  class="{{ request()->routeIs('customer.password.change') ? 'active' : '' }}"><i class="fa fa-key"></i>Đổi mật khẩu</a></li>
            <li><a href="{{route('customer.order')}}"  class="{{ request()->routeIs('customer.order') ? 'active' : '' }}"><i class="fa fa-shopping-bag"></i>Lịch sử mua hàng</a></li>
            <li><a href="{{ route('customer.logout') }}"><i class="fa fa-sign-out"></i>Đăng xuất</a></li>
        </ul>
    </div>
</aside>
<style>
    /* Sidebar container */
    .profile-sidebar {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px 15px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        font-family: Arial, sans-serif;
    }

    /* Danh sách sidebar */
    .profile-sidebar .uk-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Từng mục */
    .profile-sidebar .uk-list li {
        margin-bottom: 15px;
    }

    /* Link sidebar */
    .profile-sidebar .uk-list li a {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #333;
        font-size: 15px;
        padding: 10px 15px;
        border-radius: 8px;
        transition: 0.3s;
        text-decoration: none;
    }

    /* Icon */
    .profile-sidebar .uk-list li a i {
        font-size: 16px;
        color: #007bff;
    }

    /* Hover và Active */
    .profile-sidebar .uk-list li a:hover {
        background-color: #f0f4ff;
        color: #007bff;
        transform: translateX(4px);
    }

    .profile-sidebar .uk-list li a:hover i {
        color: #0056b3;
    }

    .profile-sidebar .uk-list li a.active {
        background-color: #e7f1ff;
        color: #007bff;
        font-weight: bold;
    }

</style>
