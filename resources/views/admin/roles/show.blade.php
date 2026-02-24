@extends('admin.layouts.main')
@section('title', 'تفاصيل الدور')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">تفاصيل الدور</h4>
                    <p class="text-muted mb-0">{{ $role->name }}</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">الأدوار</a></li>
                        <li class="breadcrumb-item active">التفاصيل</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <!-- Role Information -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">معلومات الدور</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">اسم الدور</label>
                                        <p class="form-control-plaintext">{{ $role->name }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">نوع الدور</label>
                                        <p class="form-control-plaintext">
                                            @if (in_array($role->name, ['CEO', 'super-admin', 'admin', 'support', 'user']))
                                                <span class="badge bg-primary">دور نظامي</span>
                                            @else
                                                <span class="badge bg-secondary">دور مخصص</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">عدد الصلاحيات</label>
                                        <p class="form-control-plaintext">{{ $role->permissions->count() }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">عدد المستخدمين</label>
                                        <p class="form-control-plaintext">{{ $role->users->count() }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">تاريخ الإنشاء</label>
                                        <p class="form-control-plaintext">{{ $role->created_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">آخر تحديث</label>
                                        <p class="form-control-plaintext">{{ $role->updated_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions List -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">الصلاحيات الممنوحة</h5>
                        </div>
                        <div class="card-body">
                            @if ($role->permissions->count() > 0)
                                <div class="row">
                                    @foreach ($role->permissions->groupBy(function ($permission) {
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
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="ti ti-shield-x display-1"></i>
                                    <h5 class="mt-3">لا توجد صلاحيات</h5>
                                    <p>لم يتم منح أي صلاحيات لهذا الدور</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions Sidebar -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">الإجراءات</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
                                    <i class="ti ti-edit me-1"></i>
                                    تعديل الدور
                                </a>

                                @if (!in_array($role->name, ['CEO', 'super-admin', 'admin', 'support', 'user']))
                                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="ti ti-trash me-1"></i>
                                            حذف الدور
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Users with this role -->
                    @if ($role->users->count() > 0)
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">المستخدمين المعينين ({{ $role->users->count() }})</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    @foreach ($role->users->take(5) as $user)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm flex-shrink-0 me-2">
                                                    <span class="avatar-title bg-light text-primary rounded-circle">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                                <a href="{{ route('admin.users.show', $user) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($role->users->count() > 5)
                                        <div class="list-group-item px-0 text-center">
                                            <small class="text-muted">
                                                و {{ $role->users->count() - 5 }} مستخدم آخر...
                                                <a href="{{ route('admin.users.index', ['role' => $role->name]) }}">عرض
                                                    الكل</a>
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Navigation -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>
                            العودة للقائمة
                        </a>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-primary">
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
