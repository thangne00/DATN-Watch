@extends('frontend.homepage.layout')
@section('content')
    <div class="auth-register-container">
        <div class="auth-register-box">
            <form action="{{ route('customer.reg') }}" method="POST">
                @csrf
                <h2 class="auth-title">Đăng ký tài khoản</h2>

                <div class="auth-input-group">
                    <input type="text" class="auth-input" name="name" value="{{ old('name') }}" placeholder="Họ tên">
                    @if($errors->has('name'))
                        <div class="auth-error">* {{ $errors->first('name') }}</div>
                    @endif
                </div>

                <div class="auth-input-group">
                    <input type="text" class="auth-input" name="email" value="{{ old('email') }}" placeholder="Email">
                    @if($errors->has('email'))
                        <div class="auth-error">* {{ $errors->first('email') }}</div>
                    @endif
                </div>

                <div class="auth-input-group">
                    <input type="password" class="auth-input" name="password" placeholder="Mật khẩu" autocomplete="off">
                    @if($errors->has('password'))
                        <div class="auth-error">* {{ $errors->first('password') }}</div>
                    @endif
                </div>

                <div class="auth-input-group">
                    <input type="password" class="auth-input" name="re_password" placeholder="Nhập lại mật khẩu" autocomplete="off">
                    @if($errors->has('re_password'))
                        <div class="auth-error">* {{ $errors->first('re_password') }}</div>
                    @endif
                </div>

                <div class="auth-input-group">
                    <input type="text" class="auth-input" name="phone" value="{{ old('phone') }}" placeholder="Số điện thoại">
                </div>

                <div class="auth-input-group">
                    <input type="text" class="auth-input" name="address" value="{{ old('address') }}" placeholder="Địa chỉ">
                    <input type="hidden" name="customer_catalogue_id" value="1">
                </div>

                <button type="submit" class="auth-btn">Đăng ký</button>

                <div class="auth-footer mt-4">
                    <p>Đã có tài khoản? <a href="{{ route('fe.auth.login') }}">Đăng nhập</a></p>
                    <small>{{ $system['homepage_brand'] }} </small>
                </div>
            </form>
        </div>
    </div>


    <style>
        .auth-register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f2f5;
            min-height: 50vh;
            padding: 20px;
        }

        .auth-register-box {
            background: #fff;
            width: 100%;
            max-width: 500px;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .auth-title {
            text-align: center;
            font-size: 26px;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .auth-input-group {
            margin-bottom: 20px;
        }

        .auth-input {
            width: 100%;
            padding: 14px 18px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: 0.3s;
        }

        .auth-input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .auth-error {
            font-size: 13px;
            color: red;
            margin-top: 5px;
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .auth-btn:hover {
            background-color: #0056b3;
        }

        .auth-footer {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }

        .auth-footer a {
            color: #007bff;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>


@endsection
