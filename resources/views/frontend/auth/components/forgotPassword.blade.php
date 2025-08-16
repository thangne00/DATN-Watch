@extends('frontend.homepage.layout')
@section('content')
    <style>
        /* === Forgot Password Container === */
        .forgotpassword-container {
            background: #f9f9f9;
            min-height: 40vh;
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        /* === Form Box === */
        .register-form {
            background: #fff;
            padding: 30px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .register-form .form-heading {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }

        .register-form p {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-bottom: 20px;
        }

        /* === Input Field === */
        .register-form .input-text {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            margin-bottom: 10px;
            transition: border-color 0.3s;
        }

        .register-form .input-text:focus {
            border-color: #007bff;
            outline: none;
        }

        /* === Error Message === */
        .register-form .error-message {
            font-size: 13px;
            color: red;
            margin-top: -8px;
            display: block;
        }

        /* === Submit Button === */
        .register-form .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            font-weight: 600;
            font-size: 16px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .register-form .btn:hover {
            background-color: #0056b3;
        }

        /* === Footer === */
        .register-form .m-t {
            text-align: center;
            font-size: 13px;
            color: #999;
            margin-top: 20px;
        }

    </style>
    <div class="forgotpassword-container">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">

                <div class="uk-width-large-1-1">
                    <div class="register-form">
                        <form action="{{ route($route) }}" method="get">
                            @csrf
                            <div class="form-heading">Quên mật khẩu</div>
                            <p>Nhập địa chỉ email của bạn và mật khẩu của bạn sẽ được đặt lại và gửi qua email cho
                                bạn.</p>
                            <div class="form-row">
                                <input
                                    type="text"
                                    class="input-text"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Email"
                                >
                                @if($errors->has('email'))
                                    <span class="error-message">* {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn block full-width m-b">Gửi mật khẩu mới</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
