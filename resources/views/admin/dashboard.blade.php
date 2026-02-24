@extends('admin.layouts.main')

@section('title', 'mezan store')

@section('content')
    <div class="page-content">
        <div class="page-container">

            {{-- Page Header --}}
            <div class="row">
                <div class="page-title-head d-flex align-items-center gap-2">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 text-uppercase fw-bold mb-0">mezan store</h4>
                        <p class="text-muted mb-0">نظام إدارة وتتبع الحسابات الإلكترونية</p>
                    </div>
                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0 fs-13">
                            <li class="breadcrumb-item active">لوحة التحكم</li>
                        </ol>
                    </div>
                </div>
            </div>

            {{-- Statistics --}}
            <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1 mt-3">

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي التصنيفات</h5>
                            <div class="d-flex align-items-center gap-2 my-2">
                                <span class="avatar-title bg-primary-subtle rounded-circle">
                                    <i class="ti ti-category"></i>
                                </span>
                                <h3 class="mb-0 fw-bold">
                                    {{ number_format($statistics['total_categories']) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي المنتجات</h5>
                            <div class="d-flex align-items-center gap-2 my-2">
                                <span class="avatar-title bg-success-subtle rounded-circle">
                                    <i class="ti ti-box"></i>
                                </span>
                                <h3 class="mb-0 fw-bold">
                                    {{ number_format($statistics['total_products']) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي البانرات</h5>
                            <div class="d-flex align-items-center gap-2 my-2">
                                <span class="avatar-title bg-warning-subtle rounded-circle">
                                    <i class="ti ti-photo"></i>
                                </span>
                                <h3 class="mb-0 fw-bold">
                                    {{ number_format($statistics['total_banners']) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي المستخدمين</h5>
                            <div class="d-flex align-items-center gap-2 my-2">
                                <span class="avatar-title bg-info-subtle rounded-circle">
                                    <i class="ti ti-users"></i>
                                </span>
                                <h3 class="mb-0 fw-bold">
                                    {{ number_format($statistics['total_users']) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Latest Users --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="header-title mb-0">أحدث المستخدمين</h5>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>الاسم</th>
                                            <th class="text-center">البريد الإلكتروني</th>
                                            <th class="text-center">تاريخ التسجيل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latest_users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td class="text-center">{{ $user->email }}</td>
                                                <td class="text-center">
                                                    {{ $user->created_at->format('Y-m-d H:i') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">
                                                    لا يوجد مستخدمين حديثين
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
