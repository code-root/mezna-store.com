<!doctype html>
<html lang="en">
<head>
    <title>@yield('title', 'Mezna Store')</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="Mezna Store" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/greeva/layouts/assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="https://coderthemes.com/greeva/layouts/assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="https://coderthemes.com/greeva/layouts/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="https://coderthemes.com/greeva/layouts/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="https://coderthemes.com/greeva/layouts/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/1.34.0/iconfont/tabler-icons.min.css" integrity="sha512-mWpmj8VqORtX/CTiI5Mypqx75NqtF3Ddym7C94bpi8d8nVW46OlJbtdGDcGsQDZ4VJARIgMLbzm8zyN1Ies3Qw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />

    @yield('styles')
    @include('partials.facebook-pixel')
</head>
<body>
    <div class="wrapper">

        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Brand Logo -->
                    <a href="{{ route('home') }}" class="logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img src="https://coderthemes.com/greeva/layouts/assets/images/logo.png" alt="logo"></span>
                            <span class="logo-sm"><img src="https://coderthemes.com/greeva/layouts/assets/images/logo-sm.png" alt="small logo"></span>
                        </span>

                        <span class="logo-dark">
                            <span class="logo-lg"><img src="https://coderthemes.com/greeva/layouts/assets/images/logo-dark.png" alt="dark logo"></span>
                            <span class="logo-sm"><img src="https://coderthemes.com/greeva/layouts/assets/images/logo-sm.png" alt="small logo"></span>
                        </span>
                    </a>

                    <!-- Navigation Menu -->
                    <nav class="navbar navbar-expand-lg">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">المنتجات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('about') }}">من نحن</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}">اتصل بنا</a>
                            </li>
                        </ul>
                    </nav>

                </div>

                <div class="d-flex align-items-center gap-2">

                    <!-- Light/Dark Mode Button -->
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link" id="light-dark-mode" type="button">
                            <i class="ti ti-moon fs-22"></i>
                        </button>
                    </div>

                    <!-- User Menu -->
                    @auth
                        <div class="topbar-item nav-user">
                            <div class="dropdown">
                                <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="https://coderthemes.com/greeva/layouts/assets/images/users/avatar-1.jpg" width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image">
                                    <span class="d-lg-flex flex-column gap-1 d-none">
                                        <h5 class="my-0">{{ auth()->user()->name }}</h5>
                                        <h6 class="my-0 fw-normal">User</h6>
                                    </span>
                                    <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <a href="{{ route('profile') }}" class="dropdown-item">
                                        <i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item active fw-semibold text-danger">
                                            <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                            <span class="align-middle">Sign Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="topbar-item">
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        </div>
                        <div class="topbar-item">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="page-content">
            <div class="page-container">

                @yield('content')

            </div> <!-- container -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            <script>document.write(new Date().getFullYear())</script> © Mezna Store
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="{{ route('about') }}">About</a>
                                <a href="{{ route('contact') }}">Contact</a>
                                <a href="{{ route('privacy') }}">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <!-- <script src="https://coderthemes.com/greeva/layouts/assets/js/vendor.min.js"></script> -->

    <!-- App js -->
    <!-- <script src="https://coderthemes.com/greeva/layouts/assets/js/app.js"></script> -->

    <!-- Iconify Icons -->
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Light/Dark Mode Toggle
        document.getElementById('light-dark-mode').addEventListener('click', function() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            
            // Update icon
            const icon = this.querySelector('i');
            if (newTheme === 'dark') {
                icon.className = 'ti ti-sun fs-22';
            } else {
                icon.className = 'ti ti-moon fs-22';
            }
        });

        // Initialize theme from localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            
            const icon = document.querySelector('#light-dark-mode i');
            if (savedTheme === 'dark') {
                icon.className = 'ti ti-sun fs-22';
            } else {
                icon.className = 'ti ti-moon fs-22';
            }
        });
    </script>

    @yield('scripts')
</body>
</html> 