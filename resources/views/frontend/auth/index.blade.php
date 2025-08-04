@extends('frontend.homepage.layout')

@section('content')
    <div class="auth-container">
        <div class="auth-box-single">
            <form action="{{ route('fe.auth.dologin') }}" method="GET" class="auth-form">
                @csrf
                <h2 class="auth-title">Đăng nhập</h2>

                <div class="auth-input-group">
                    <input
                        type="text"
                        name="email"
                        placeholder="Email đăng nhập"
                        class="auth-input"
                        required
                    >
                </div>

                <div class="auth-input-group">
                    <input
                        type="password"
                        name="password"
                        placeholder="Mật khẩu"
                        class="auth-input"
                        required
                    >
                </div>

                <button type="submit" class="auth-btn">Đăng nhập</button>

                <div class="auth-options">
                    <a href="{{ route('forgot.customer.password') }}">Quên mật khẩu?</a>
                </div>

                <div class="auth-register">
                    Bạn mới biết đến {{ $system['homepage_brand'] }}?
                    <a href="{{ route('customer.register') }}">Đăng ký</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            background: #f0f2f5;
            padding: 20px;
        }

        .auth-box-single {
            background: #fff;
            width: 100%;
            max-width: 480px;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .auth-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 26px;
            font-weight: 600;
            color: #333;
        }

        .auth-input-group {
            margin-bottom: 20px;
        }

        .auth-input {
            width: 100%;
            padding: 14px 18px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .auth-input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.2);
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .auth-btn:hover {
            background-color: #0056b3;
        }

        .auth-options {
            text-align: right;
            margin-top: 10px;
            font-size: 14px;
        }

        .auth-options a {
            color: #007bff;
            text-decoration: none;
        }

        .auth-options a:hover {
            text-decoration: underline;
        }

        .auth-register {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .auth-register a {
            color: #007bff;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-register a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
