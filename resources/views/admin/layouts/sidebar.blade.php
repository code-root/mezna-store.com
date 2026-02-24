<!-- Sidenav Menu Start -->
<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <span class="logo-light">
            <span class="logo-lg">
                <i class="ti ti-mail text-primary fs-24"></i>
                <span class="ms-2 fw-bold text-white">Mezna Store</span>
            </span>
            <span class="logo-sm">
                <i class="ti ti-mail text-primary fs-20"></i>
            </span>
        </span>

        <span class="logo-dark">
            <span class="logo-lg">
                <i class="ti ti-mail text-primary fs-24"></i>
                <span class="ms-2 fw-bold text-dark">Mezna Store</span>
            </span>
            <span class="logo-sm">
                <i class="ti ti-mail text-primary fs-20"></i>
            </span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ti ti-circle align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div data-simplebar>

        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title">القائمة الرئيسية</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="side-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                    <span class="menu-text">لوحة التحكم</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmails" aria-expanded="false" aria-controls="sidebarEmails"
                    class="side-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-mail"></i></span>
                    <span class="menu-text">المنتجات</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmails">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.products.index') }}"
                                class="side-nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                <span class="menu-text">جميع المنتجات</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.products.create') }}"
                                class="side-nav-link {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                <span class="menu-text">إضافة منتج جديد</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- <!-- إدارة المستخدمين -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarUsers" aria-expanded="false" aria-controls="sidebarUsers"
                    class="side-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-users"></i></span>
                    <span class="menu-text">المستخدمين</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarUsers">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="side-nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <span class="menu-text">جميع المستخدمين</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.users.create') }}"
                                class="side-nav-link {{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                                <span class="menu-text">إضافة مستخدم</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> --}}


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCategories" aria-expanded="false"
                    aria-controls="sidebarCategories"
                    class="side-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-folder"></i></span>
                    <span class="menu-text">الأقسام</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCategories">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                                class="side-nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                                <span class="menu-text">جميع الأقسام</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.categories.create') }}"
                                class="side-nav-link {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                                <span class="menu-text">إضافة قسم</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.visits.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.visits.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-chart-line"></i></span>
                    <span class="menu-text">إحصائيات الزيارات</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.hero-slides.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-photo"></i></span>
                    <span class="menu-text">صور الهيرو (الكاروسيل)</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.page-contents.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.page-contents.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-file-text"></i></span>
                    <span class="menu-text">الشحن / الاسترجاع / FAQ</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarBanners" aria-expanded="false" aria-controls="sidebarBanners"
                    class="side-nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-banner"></i></span>
                    <span class="menu-text">البانرات</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarBanners">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="{{ route('admin.banners.index') }}"
                                class="side-nav-link {{ request()->routeIs('admin.banners.index') ? 'active' : '' }}">
                                <span class="menu-text">جميع البانرات</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="{{ route('admin.banners.create') }}"
                                class="side-nav-link {{ request()->routeIs('admin.banners.create') ? 'active' : '' }}">
                                <span class="menu-text">إضافة بانر جديد </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>



            <li class="side-nav-title mt-2">إدارة النظام</li>

            <!-- الأدوار والصلاحيات -->
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRoles" aria-expanded="false" aria-controls="sidebarRoles"
                    class="side-nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-shield"></i></span>
                    <span class="menu-text">الأدوار والصلاحيات</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRoles">
                    <ul class="sub-menu">
                        {{-- <li class="side-nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="side-nav-link {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                <span class="menu-text">إدارة الأدوار</span>
                            </a>
                        </li> --}}
                        <li class="side-nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="side-nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <span class="menu-text">إدارة المستخدمين</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- 
            <!-- الإعدادات -->
            <li class="side-nav-item">
                <a href="{{ route('admin.settings.index') }}"
                    class="side-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="ti ti-settings"></i></span>
                    <span class="menu-text">الإعدادات</span>
                </a>
            </li> --}}

        </ul>


        <div class="clearfix"></div>
    </div>
</div>
<!-- Sidenav Menu End -->
