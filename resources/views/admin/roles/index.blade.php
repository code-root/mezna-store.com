@extends('admin.layouts.main')
@section('title', 'إدارة الأدوار والصلاحيات')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">إدارة الأدوار والصلاحيات</h4>
                <p class="text-muted mb-0">عرض وإدارة الأدوار والصلاحيات في النظام</p>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item active">الأدوار والصلاحيات</li>
                </ol>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-3">
            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary text-white rounded">
                                    <i class="ti ti-shield"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mt-0 mb-1">{{ number_format($roles->total()) }}</h4>
                                <p class="text-muted mb-0">إجمالي الأدوار</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success text-white rounded">
                                    <i class="ti ti-lock"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mt-0 mb-1">{{ $roles->sum(function($role) { return $role->permissions->count(); }) }}</h4>
                                <p class="text-muted mb-0">إجمالي الصلاحيات</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info text-white rounded">
                                    <i class="ti ti-users"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mt-0 mb-1">{{ $roles->sum(function($role) { return $role->users->count(); }) }}</h4>
                                <p class="text-muted mb-0">المستخدمين المعينين</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.roles.index') }}" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">البحث</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="ابحث في اسم الدور..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-search me-1"></i>
                            بحث
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh me-1"></i>
                            إعادة تعيين
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i>
                    إضافة دور جديد
                </a>
            </div>
        </div>

        <!-- Roles Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الدور</th>
                                <th>عدد الصلاحيات</th>
                                <th>عدد المستخدمين</th>
                                <th>نوع الدور</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0 me-2">
                                            <span class="avatar-title bg-light text-primary rounded">
                                                <i class="ti ti-shield"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $role->name }}</h6>
                                            @if($role->name === 'CEO')
                                                <small class="badge bg-danger">أعلى صلاحية</small>
                                            @elseif($role->name === 'super-admin')
                                                <small class="badge bg-warning">مدير فائق</small>
                                            @elseif($role->name === 'admin')
                                                <small class="badge bg-info">مدير</small>
                                            @elseif($role->name === 'support')
                                                <small class="badge bg-secondary">دعم</small>
                                            @else
                                                <small class="badge bg-light text-dark">مخصص</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $role->permissions->count() }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $role->users->count() }}</span>
                                </td>
                                <td>
                                    @if(in_array($role->name, ['CEO', 'super-admin', 'admin', 'support', 'user']))
                                        <span class="badge bg-primary">نظامي</span>
                                    @else
                                        <span class="badge bg-secondary">مخصص</span>
                                    @endif
                                </td>
                                <td>{{ $role->created_at->format('Y/m/d') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.roles.show', $role) }}"
                                           class="btn btn-sm btn-soft-primary" title="عرض">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.roles.edit', $role) }}"
                                           class="btn btn-sm btn-soft-secondary" title="تعديل">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        @if(!in_array($role->name, ['CEO', 'super-admin', 'admin', 'support', 'user']))
                                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" title="حذف">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-shield-off text-muted display-1"></i>
                                        <h5 class="mt-3">لا توجد أدوار</h5>
                                        <p>لم يتم العثور على أي أدوار في النظام</p>
                                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                                            <i class="ti ti-plus me-1"></i>
                                            إضافة دور جديد
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($roles->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $roles->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
