@extends('frontend.homepage.layout')
@section('content')
    <style>
        /* Tổng thể */
        .profile-container {
            background: #f8f9fa;
            padding: 40px 0;
            font-family: Arial, sans-serif;
        }

        /* Khối form */
        .panel-profile {
            background-color: #fff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        /* Phần tiêu đề */
        .panel-head .heading-2 {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .panel-head .description {
            font-size: 14px;
            color: #777;
            margin-bottom: 25px;
        }

        /* Label + input */
        .profile-form .form-row {
            margin-bottom: 22px;
        }

        .profile-form label.uk-form-label {
            font-weight: 600;
            margin-bottom: 6px;
            color: #444;
            display: block;
        }

        .profile-form .uk-form-controls {
            width: 100%;
        }

        .profile-form input.input-text {
            width: 50%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s;
        }

        .profile-form input.input-text:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
            outline: none;
        }

        /* Tài khoản hiển thị thụ động */
        .profile-form .uk-form-controls:not(:has(input)) {
            padding: 10px 0;
            color: #555;
            font-weight: 500;
        }

        /* Nút lưu */
        .profile-form button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .profile-form button[type="submit"]:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .uk-width-large-1-4,
            .uk-width-large-2-4 {
                width: 100% !important;
            }

            .panel-profile {
                padding: 20px;
            }
        }
    </style>

    <div class="profile-container pt20 pb20">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-1-4">
                    @include('frontend.auth.customer.components.sidebar')
                </div>
                <div class="uk-width-large-2-4">
                    <div class="panel-profile">
                        <div class="panel-head"><br>

                            <h2 class="heading-2"><span>Hồ sơ của tôi</span></h2><br>
                            <div class="description">
                                Quản lý thông tin hồ sơ để bảo mật tài khoản
                            </div><br>
                        </div>
                        <div class="panel-body">
                            @include('backend/dashboard/component/formError')
                            <form action="{{ route('customer.profile.update') }}" method="post" class="uk-form uk-form-horizontal login-form profile-form">
                                @csrf
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Tài khoản đăng nhập</label>
                                    <div class="uk-form-controls">
                                        {{ $customer->email }}
                                    </div>
                                </div>

                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Họ Tên</label>
                                    <div class="uk-form-controls">
                                        <input
                                            type="text"
                                            class="input-text"
                                            placeholder="Họ Tên"
                                            name="name"
                                            value="{{ old('name', $customer->name) }}"
                                        >
                                    </div>
                                </div>
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Email</label>
                                    <div class="uk-form-controls">
                                        <input
                                            type="text"
                                            class="input-text"
                                            placeholder="Email"
                                            name="email"
                                            value="{{ old('email', $customer->email) }}"
                                        >
                                    </div>
                                </div>
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Số điện thoại</label>
                                    <div class="uk-form-controls">
                                        <input
                                            type="text"
                                            class="input-text"
                                            placeholder="Số điện thoại"
                                            name="phone"
                                            value="{{ old('phone', $customer->phone) }}"
                                        >
                                    </div>
                                </div>
                                <div class="uk-form-row form-row">
                                    <label class="uk-form-label" for="form-h-it">Địa chỉ</label>
                                    <div class="uk-form-controls">
                                        <input
                                            type="text"
                                            class="input-text"
                                            placeholder="Địa chỉ"
                                            name="address"
                                            value="{{ old('address', $customer->address) }}"
                                        >
                                    </div>
                                </div>
                                <button type="submit" name="send" value="create">Lưu thông tin</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



