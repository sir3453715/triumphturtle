<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Colorlib">
    <title>後台系統</title>
    <style>
        .login-bg {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: -1;
            background: url("{{asset('storage/image/img.png')}}") center center no-repeat;
            background-size: cover;
        }
        .login-form{
            width: 33.3%;
            margin: 0px auto;
        }
        .login-content {
            margin-top: 10%;
        }
        .login-content h4 {
            text-align: center;
            padding-bottom: 1rem;
            color: #d34626;
            font-weight: bold;
        }
        .login-content form {
            text-align: -webkit-center;
        }
        .login-content form input {
            padding-right: 0;
        }
        .login-content form .form-group {
            padding-right: 0;
            margin: 5px;
            margin-top: 10px;
        }
        .form-control {
            display: block;
            height: calc(1.2em + 0.5rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            margin-top: 5px;
        }
        .login-btn {
            color: #fff !important;
            text-transform: uppercase;
            text-decoration: none;
            background: #434343;
            padding: 15px 30px 15px 30px;
            border-radius: 5px;
            display: inline-block;
            border: none;
            transition: all 0.4s ease 0s;
        }
        .login-btn:hover {
             background: #ed3330;
             letter-spacing: 1px;
             -webkit-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
             -moz-box-shadow: 0px 5px 40px -10px rgba(0,0,0,0.57);
             box-shadow: 5px 40px -10px rgba(0,0,0,0.57);
             transition: all 0.4s ease 0s;
         }
        .alert{
            text-align: center;
            width: 50%;
            margin-left: 25%;
        }
        .alert-danger{
            background-color: #fecdd3;
            border-color: #fecdd3;
            color: #822933;
        }
    </style>
</head>
<body class="fix-header fix-sidebar">
<!-- Main wrapper  -->
<div class="c-body login-bg">
    <main class="c-main">
        <div class="container-fluid">
            @error('email')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
            @error('password')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
            @enderror
            @if (\Session::has('message'))
                <div class="alert alert-success">
                    {!! \Session::get('message') !!}
                </div>
            @endif
            @if (\Session::has('Errormessage'))
                <div class="alert alert-danger">
                    {!! \Session::get('Errormessage') !!}
                </div>
            @endif
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <div class="login-form">
                                <h4 class="login-form-title">後台登入</h4>
                                <form method="POST" action="{{ route('login') }}">
                                    <input id="login_by" type="hidden"  name="login_by" value="admin">
                                    @csrf
                                    <input id="loginFlag" type="hidden" class="form-control" name="loginFlag" value="backstage">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">帳號</label>
                                        <div class="col-md-6">
                                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">密碼</label>
                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    記得我
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="login-btn">
                                                登入
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@stack('admin-app-scripts')
</body>
</html>
