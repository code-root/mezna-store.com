@extends('admin.layouts.main')
@section('title', 'تفاصيل المستخدم')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">تفاصيل المستخدم</h4>
                    <p class="text-muted mb-0">{{ $user->name }}</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمين</a></li>
                        <li class="breadcrumb-item active">التفاصيل</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <!-- User Information -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">معلومات المستخدم</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">الاسم</label>
                                        <p class="form-control-plaintext">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">البريد الإلكتروني</label>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">حالة البريد الإلكتروني</label>
                                        <p class="form-control-plaintext">
                                            @if ($user->email_verified_at)
                                                <span class="badge bg-success">
                                                    <i class="ti ti-check me-1"></i>
                                                    مفعل ({{ $user->email_verified_at->format('Y/m/d H:i') }})
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="ti ti-clock me-1"></i>
                                                    غير مفعل
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">تاريخ التسجيل</label>
                                        <p class="form-control-plaintext">{{ $user->created_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">آخر نشاط</label>
                                        <p class="form-control-plaintext">{{ $user->updated_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Roles -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">الأدوار المعينة</h5>
                        </div>
                        <div class="card-body">
                            @if ($user->roles->count() > 0)
                                <div class="row">
                                    @foreach ($user->roles as $role)
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 border-primary">
                                                <div class="card-body text-center">
                                                    <i class="ti ti-shield text-primary display-4 mb-2"></i>
                                                    <h6 class="card-title">{{ $role->name }}</h6>
                                                    <small class="text-muted">{{ $role->permissions->count() }}
                                                        صلاحية</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="ti ti-shield-x display-1"></i>
                                    <h5 class="mt-3">لا توجد أدوار</h5>
                                    <p>لم يتم تعيين أي أدوار لهذا المستخدم</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- User Permissions -->
                    @if ($user->getAllPermissions()->count() > 0)
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">الصلاحيات المتاحة ({{ $user->getAllPermissions()->count() }})
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($user->getAllPermissions()->groupBy(function ($permission) {
            return explode('.', $permission->name)[1] ?? 'general';
        }) as $model => $permissions)
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-header">
                                                    <h6 class="card-title mb-0">{{ ucfirst($model) }}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach ($permissions as $permission)
                                                            <span
                                                                class="badge bg-primary">{{ ucfirst(explode('.', $permission->name)[0]) }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Actions Sidebar -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">الإجراءات</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                                    <i class="ti ti-edit me-1"></i>
                                    تعديل المستخدم
                                </a>

                                @can('manage.roles')
                                    <div class="mt-3">
                                        <h6 class="fw-bold">إدارة الأدوار</h6>
                                        @if ($user->roles->count() > 0)
                                            @foreach ($user->roles as $role)
                                                <form method="POST"
                                                    action="{{ route('admin.roles.remove-user', [$role, $user]) }}"
                                                    class="d-inline-block mb-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('هل أنت متأكد من إزالة الدور {{ $role->name }} من هذا المستخدم؟')">
                                                        <i class="ti ti-minus me-1"></i>
                                                        إزالة {{ $role->name }}
                                                    </button>
                                                </form>
                                            @endforeach
                                        @endif

                                        <hr>
                                        <form method="POST" action="{{ route('admin.roles.assign-to-user') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <div class="mb-2">
                                                <select name="role_name" class="form-select form-select-sm" required>
                                                    <option value="">اختر دور للإضافة</option>
                                                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                                                        @if (!$user->hasRole($role->name))
                                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-success w-100">
                                                <i class="ti ti-plus me-1"></i>
                                                إضافة دور
                                            </button>
                                        </form>
                                    </div>
                                @endcan

                                @if ($user->id !== auth()->id())
                                    <div class="mt-3 pt-3 border-top">
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="ti ti-trash me-1"></i>
                                                حذف المستخدم
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>
                            العودة للقائمة
                        </a>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>
                                تعديل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
