@extends('frontend.homepage.layout')

@section('content')
    <div class="profile-container pt20 pb20">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-1-4">
                    @include('frontend.auth.customer.components.sidebar')
                </div>
    <div class="change-password-container">

        <div class="change-password-box">

            <div class="change-password-head">
                <h2>Thay đổi mật khẩu</h2>
                <p>Quản lý thông tin hồ sơ để bảo mật tài khoản. Vui lòng nhập đầy đủ thông tin để thay đổi mật khẩu.</p>
            </div>

            @include('backend/dashboard/component/formError')

            <form action="{{ route('customer.password.recovery') }}" method="POST" class="change-password-form">
                @csrf

                <div class="change-password-group">
                    <label for="password">Mật khẩu cũ</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="change-password-input"
                        placeholder="Nhập mật khẩu cũ"
                    >
                </div>

                <div class="change-password-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        class="change-password-input"
                        placeholder="Nhập mật khẩu mới"
                    >
                </div>

                <div class="change-password-group">
                    <label for="re_new_password">Nhập lại mật khẩu mới</label>
                    <input
                        type="password"
                        id="re_new_password"
                        name="re_new_password"
                        class="change-password-input"
                        placeholder="Nhập lại mật khẩu mới"
                    >
                </div>

                <button type="submit" class="change-password-btn">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
            </div></div></div>
    <style>
        .change-password-container {
            display: flex;
            justify-content: center;
            /*padding: 40px 20px;*/

        }

        .change-password-box {
            background-color: #fff;
            width: 100%;
            max-width: 600px;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        .change-password-head h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .change-password-head p {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .change-password-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .change-password-group label {
            font-size: 14px;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        .change-password-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s;
        }

        .change-password-input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.1);
        }

        .change-password-btn {
            padding: 14px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .change-password-btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 576px) {
            .change-password-box {
                padding: 30px 20px;
            }

            .change-password-head h2 {
                font-size: 20px;
            }
        }
    </style>
@endsection
