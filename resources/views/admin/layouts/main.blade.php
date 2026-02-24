<!doctype html>
<html lang="ar" dir="rtl">
@include('admin.layouts.head')
<body>
    <!-- Begin page -->
    <div class="wrapper">


        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')

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