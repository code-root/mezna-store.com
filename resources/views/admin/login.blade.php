<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <title>تسجيل الدخول </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="نظام الأسعار لمتجر ميزان" name="description" />
    <meta content="متجر ميزان" name="author" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/greeva/layouts/assets/images/favicon.ico">

    <!-- App css -->
    <link href="https://coderthemes.com/greeva/layouts/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="https://coderthemes.com/greeva/layouts/assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="https://coderthemes.com/greeva/layouts/assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" disabled />
    
    <!-- Custom RTL CSS -->
    <link href="{{ asset('assets/css/custom-rtl.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="loading authentication-bg" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <a href="{{ route('admin.dashboard') }}">
                                    <span><img src="https://coderthemes.com/greeva/layouts/assets/images/logo-dark.png" alt="" height="22"></span>
                                </a>
                                <p class="text-muted mb-4 mt-3">أدخل بريدك الإلكتروني وكلمة المرور للوصول إلى لوحة التحكم.</p>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="أدخل بريدك الإلكتروني">
                                </div>

                                <div class="mb-3">
                                    <a href="" class="text-muted float-end"><small>نسيت كلمة المرور؟</small></a>
                                    <label for="password" class="form-label">كلمة المرور</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary w-100" type="submit">تسجيل الدخول</button>
                                </div>
                            </form>
                        </div>
                    </div>

             
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor js -->
    <script src="https://coderthemes.com/greeva/layouts/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="https://coderthemes.com/greeva/layouts/assets/js/app.min.js"></script>
</body>
</html>
