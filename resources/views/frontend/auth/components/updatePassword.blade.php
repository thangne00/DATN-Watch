@extends('frontend.homepage.layout')

@section('content')
    <div class="forgotpass-container">
        <div class="forgotpass-box">
            <form action="{{ route($route, $email) }}" method="POST" class="forgotpass-form">
                @csrf
                <h2 class="forgotpass-title">Cập nhật mật khẩu</h2>

                <div class="forgotpass-group">
                    <input
                        type="password"
                        name="password"
                        class="forgotpass-input"
                        placeholder="Mật khẩu mới"
                        required
                    >
                </div>

                <div class="forgotpass-group">
                    <input
                        type="password"
                        name="re_password"
                        class="forgotpass-input"
                        placeholder="Nhập lại mật khẩu"
                        required
                    >
                </div>

                <button type="submit" class="forgotpass-btn">Đổi mật khẩu</button>

                
            </form>
        </div>
    </div>

    <style>
        .forgotpass-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            background: #f0f2f5;
            padding: 20px;
        }

        .forgotpass-box {
            background-color: #fff;
            width: 100%;
            max-width: 460px;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .forgotpass-title {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .forgotpass-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .forgotpass-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .forgotpass-input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.15);
        }

        .forgotpass-btn {
            padding: 14px;
            background-color: #007bff;
            color: white;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .forgotpass-btn:hover {
            background-color: #0056b3;
        }

        .forgotpass-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #555;
        }
    </style>
@endsection
