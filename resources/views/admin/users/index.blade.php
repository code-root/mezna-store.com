@extends('admin.layouts.main')
@section('title', 'إدارة المستخدمين')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">إدارة المستخدمين</h4>
                    <p class="text-muted mb-0">عرض وإدارة جميع المستخدمين المسجلين في النظام</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">المستخدمين</li>
                    </ol>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-3">
                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary text-white rounded">
                                        <i class="ti ti-users"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mt-0 mb-1">{{ number_format($users->total()) }}</h4>
                                    <p class="text-muted mb-0">إجمالي المستخدمين</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success text-white rounded">
                                        <i class="ti ti-user-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mt-0 mb-1">{{ $users->where('email_verified_at', '!=', null)->count() }}</h4>
                                    <p class="text-muted mb-0">مستخدمين مفعلين</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">الدور</label>
                            <select name="role" class="form-select">
                                <option value="">جميع الأدوار</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ request('role') == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">البحث</label>
                            <input type="text" name="search" class="form-control"
                                placeholder="ابحث في الاسم أو البريد الإلكتروني..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="ti ti-search me-1"></i>
                                بحث
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
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
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i>
                        إضافة مستخدم جديد
                    </a>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>المستخدم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدور</th>
                                    <th>حالة التحقق</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm flex-shrink-0 me-2">
                                                    <span class="avatar-title bg-light text-primary rounded-circle">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->roles->count() > 0)
                                                @foreach ($user->roles as $role)
                                                    <span class="badge bg-info me-1">{{ $role->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge bg-light text-dark">بدون دور</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->email_verified_at)
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check me-1"></i>
                                                    مفعل
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="ti ti-clock me-1"></i>
                                                    غير مفعل
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('Y/m/d') }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="btn btn-sm btn-soft-primary" title="عرض">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="btn btn-sm btn-soft-secondary" title="تعديل">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                @if ($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                        class="d-inline"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-soft-danger"
                                                            title="حذف">
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
                                                <i class="ti ti-users text-muted display-1"></i>
                                                <h5 class="mt-3">لا توجد مستخدمين</h5>
                                                <p>لم يتم العثور على أي مستخدمين في النظام</p>
                                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                                    <i class="ti ti-plus me-1"></i>
                                                    إضافة مستخدم جديد
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
