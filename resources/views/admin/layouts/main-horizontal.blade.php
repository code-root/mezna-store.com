<!doctype html>
<html lang="ar" dir="rtl" data-layout="topnav">
@include('admin.layouts.head')

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- Topbar Start -->
        <header class="app-topbar">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">

                    <!-- Brand Logo -->
                    <a href="{{ route('admin.dashboard') }}" class="logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img
                                    src="https://coderthemes.com/greeva/layouts/assets/images/logo.png"
                                    alt="logo"></span>
                            <span class="logo-sm"><img
                                    src="https://coderthemes.com/greeva/layouts/assets/images/logo-sm.png"
                                    alt="small logo"></span>
                        </span>

                        <span class="logo-dark">
                            <span class="logo-lg"><img
                                    src="https://coderthemes.com/greeva/layouts/assets/images/logo-dark.png"
                                    alt="dark logo"></span>
                            <span class="logo-sm"><img
                                    src="https://coderthemes.com/greeva/layouts/assets/images/logo-sm.png"
                                    alt="small logo"></span>
                        </span>
                    </a>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="sidenav-toggle-button px-2">
                        <i class="ti ti-menu-deep fs-24"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="topnav-toggle-button px-2" data-bs-toggle="collapse"
                        data-bs-target="#topnav-menu-content">
                        <i class="ti ti-menu-deep fs-22"></i>
                    </button>

                    <!-- Button Trigger Search Modal -->
                    <div class="topbar-search text-muted d-none d-xl-flex gap-2 align-items-center"
                        data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                        <i class="ti ti-search fs-18"></i>
                        <span class="me-2">البحث...</span>
                        <span class="ms-auto fw-medium">⌘K</span>
                    </div>

                </div>

                <div class="d-flex align-items-center gap-2">

                    <!-- Search for small devices -->
                    <div class="topbar-item d-flex d-xl-none">
                        <button class="topbar-link" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                            <i class="ti ti-search fs-22"></i>
                        </button>
                    </div>

                    <!-- Notification Dropdown -->
                    <div class="topbar-item">
                        <div class="dropdown">
                            <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown"
                                data-bs-offset="0,25" type="button" data-bs-auto-close="outside" aria-haspopup="false"
                                aria-expanded="false">
                                <i class="ti ti-bell animate-ring fs-22"></i>
                                <span class="noti-icon-badge"></span>
                            </button>

                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg"
                                style="min-height: 300px;">
                                <div class="p-3 border-bottom border-dashed">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold">الإشعارات</h6>
                                        </div>
                                        <div class="col-auto">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle drop-arrow-none link-dark"
                                                    data-bs-toggle="dropdown" data-bs-offset="0,15"
                                                    aria-expanded="false">
                                                    <i class="ti ti-settings fs-22 align-middle"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a href="javascript:void(0);" class="dropdown-item">تحديد كمقروء</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">حذف الكل</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="position-relative z-2 card shadow-none rounded-0" style="max-height: 300px;"
                                    data-simplebar>
                                    <!-- Notification items will be dynamically loaded here -->
                                </div>

                                <div style="height: 300px;"
                                    class="d-flex align-items-center justify-content-center text-center position-absolute top-0 bottom-0 start-0 end-0 z-1">
                                    <div>
                                        <i class="ti ti-bell fs-80 text-secondary mt-2"></i>
                                        <h4 class="fw-semibold mb-0 fst-italic lh-base mt-3">مرحباً! 👋 <br />لا توجد
                                            إشعارات</h4>
                                    </div>
                                </div>

                                <a href="javascript:void(0);"
                                    class="dropdown-item notification-item position-fixed z-2 bottom-0 text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">
                                    عرض الكل
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Light/Dark Mode Button -->
                    <div class="topbar-item d-none d-sm-flex">
                        <button class="topbar-link" id="light-dark-mode" type="button">
                            <i class="ti ti-moon fs-22"></i>
                        </button>
                    </div>

                    <!-- User Dropdown -->
                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                                data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">
                                <img src="https://coderthemes.com/greeva/layouts/assets/images/users/avatar-1.jpg"
                                    width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image">
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h5 class="my-0">{{ auth()->user()->name ?? 'المدير' }}</h5>
                                    <h6 class="my-0 fw-normal">مدير النظام</h6>
                                </span>
                                <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">مرحباً !</h6>
                                </div>

                                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                                    <i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">الملف الشخصي</span>
                                </a>

                                <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                                    <i class="ti ti-settings me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">الإعدادات</span>
                                </a>

                                <div class="dropdown-divider"></div>

                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item active fw-semibold text-danger">
                                        <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                        <span class="align-middle">تسجيل الخروج</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow bg-transparent">
                    <form>
                        <div class="card mb-1">
                            <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                                <i class="ti ti-search fs-22"></i>
                                <input type="search" class="form-control border-0" id="search-modal-input"
                                    placeholder="البحث في المنتجات والحملات...">
                                <button type="submit" class="btn p-0" data-bs-dismiss="modal"
                                    aria-label="Close">[esc]</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Horizontal Menu Start -->
        <header class="topnav">
            <nav class="navbar navbar-expand-lg">
                <nav class="page-container">
                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <!-- لوحة التحكم -->
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle drop-arrow-none {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                                    <span class="menu-text">لوحة التحكم</span>
                                </a>
                            </li>

                            <!-- المنتجات -->
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle drop-arrow-none {{ request()->routeIs('admin.campaign-products.*') ? 'active' : '' }}"
                                    href="#" id="topnav-products" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="menu-icon"><i class="ti ti-package"></i></span>
                                    <span class="menu-text">المنتجات</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-products">
                                    <a href="{{ route('admin.campaign-products.index') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.campaign-products.index') ? 'active' : '' }}">جميع
                                        المنتجات</a>
                                    <a href="{{ route('admin.campaign-products.sync') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.campaign-products.sync') ? 'active' : '' }}">مزامنة
                                        المنتجات</a>
                                </div>
                            </li>

                            <!-- الحملات -->
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle drop-arrow-none {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}"
                                    href="#" id="topnav-campaigns" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="menu-icon"><i class="ti ti-badge-percent"></i></span>
                                    <span class="menu-text">الحملات</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-campaigns">
                                    <a href="{{ route('admin.campaigns.index') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.campaigns.index') ? 'active' : '' }}">جميع
                                        الحملات</a>
                                    <a href="{{ route('admin.campaigns.create') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.campaigns.create') ? 'active' : '' }}">إضافة
                                        حملة</a>
                                </div>
                            </li>

                            <!-- المنافسون -->
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle drop-arrow-none {{ request()->routeIs('admin.product-competitors.*') ? 'active' : '' }}"
                                    href="{{ route('admin.product-competitors.index') }}">
                                    <span class="menu-icon"><i class="ti ti-users"></i></span>
                                    <span class="menu-text">المنافسون</span>
                                </a>
                            </li>

                            <!-- التحليل -->
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle drop-arrow-none {{ request()->routeIs('admin.product-analysis.*') ? 'active' : '' }}"
                                    href="{{ route('admin.product-analysis.index') }}">
                                    <span class="menu-icon"><i class="ti ti-chart-bar"></i></span>
                                    <span class="menu-text">تحليل المنتجات</span>
                                </a>
                            </li>

                            <!-- ترينديول -->
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle drop-arrow-none {{ request()->routeIs('admin.trendyol.*') ? 'active' : '' }}"
                                    href="#" id="topnav-trendyol" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="menu-icon"><i class="ti ti-shopping-cart"></i></span>
                                    <span class="menu-text">ترينديول</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-trendyol">
                                    <a href="{{ route('admin.trendyol.dashboard') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.trendyol.dashboard') ? 'active' : '' }}">لوحة
                                        ترينديول</a>
                                    <a href="{{ route('admin.trendyol.accounts') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.trendyol.accounts') ? 'active' : '' }}">الحسابات</a>
                                </div>
                            </li>

                            <!-- إدارة النظام -->
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle drop-arrow-none {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') || request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                                    href="#" id="topnav-system" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="menu-icon"><i class="ti ti-settings"></i></span>
                                    <span class="menu-text">إدارة النظام</span>
                                    <div class="menu-arrow"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-system">
                                    <div class="dropdown hover-dropdown">
                                        <a class="dropdown-item dropdown-toggle drop-arrow-none" href="#"
                                            id="topnav-users" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            المستخدمين
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-users">
                                            <a href="{{ route('admin.users.index') }}"
                                                class="dropdown-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">جميع
                                                المستخدمين</a>
                                            <a href="{{ route('admin.users.create') }}"
                                                class="dropdown-item {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">إضافة
                                                مستخدم</a>
                                        </div>
                                    </div>
                                    <div class="dropdown hover-dropdown">
                                        <a class="dropdown-item dropdown-toggle drop-arrow-none" href="#"
                                            id="topnav-data" role="button" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            إدارة البيانات
                                            <div class="menu-arrow"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-data">
                                            <a href="{{ route('admin.brands.index') }}"
                                                class="dropdown-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">ماركات
                                                السيارات</a>
                                            <a href="{{ route('admin.types.index') }}"
                                                class="dropdown-item {{ request()->routeIs('admin.types.*') ? 'active' : '' }}">أنواع
                                                السيارات</a>
                                            <a href="{{ route('admin.cars.index') }}"
                                                class="dropdown-item {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">السيارات</a>
                                            <a href="{{ route('admin.services.index') }}"
                                                class="dropdown-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">الخدمات</a>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.settings.index') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">الإعدادات</a>
                                    <a href="{{ route('admin.profile') }}"
                                        class="dropdown-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">الملف
                                        الشخصي</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>
        </header>
        <!-- Horizontal Menu End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        @yield('content')

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    @include('admin.layouts.scripts')
    @yield('footer-script')
    @stack('scripts')
</body>

</html>
