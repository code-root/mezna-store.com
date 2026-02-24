<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <title>خطأ {{ $exception->getStatusCode() ?? 404 }} - Mezna Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="نظام إدارة متجر Mezna Store" name="description" />
    <meta content="Mezna Store" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/greeva/layouts/assets/images/favicon.ico">

    <!-- App css -->
    <link href="https://coderthemes.com/greeva/layouts/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="https://coderthemes.com/greeva/layouts/assets/css/app.min.css" rel="stylesheet" type="text/css"
        id="light-style" />
    <link href="https://coderthemes.com/greeva/layouts/assets/css/app-dark.min.css" rel="stylesheet" type="text/css"
        id="dark-style" disabled />

    <!-- Custom RTL CSS -->
    <link href="{{ asset('assets/css/custom-rtl.css') }}" rel="stylesheet" type="text/css" />
    @include('partials.facebook-pixel')
</head>

<body class="loading"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="mb-4">
                                    <span class="avatar-title bg-light rounded-circle">
                                        <i class="ti ti-alert-triangle text-danger fs-32"></i>
                                    </span>
                                </div>
                                <h1 class="text-danger fw-bold">{{ $exception->getStatusCode() ?? 404 }}</h1>
                                <h4 class="text-uppercase text-muted mt-3">
                                    {{ $exception->getMessage() ?? 'الصفحة غير موجودة' }}</h4>
                                <p class="text-muted mt-3">عذراً، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>

                                <div class="mt-4">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary me-2">
                                        <i class="ti ti-home"></i> لوحة التحكم
                                    </a>
                                    <a href="{{ url()->previous() }}" class="btn btn-light">
                                        <i class="ti ti-arrow-left"></i> العودة للخلف
                                    </a>
                                </div>
                            </div>
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
