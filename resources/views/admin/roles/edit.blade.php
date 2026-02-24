@extends('admin.layouts.main')
@section('title', 'تعديل الدور')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">تعديل الدور</h4>
                    <p class="text-muted mb-0">تعديل الدور وصلاحياته</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">الأدوار</a></li>
                        <li class="breadcrumb-item active">تعديل</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">بيانات الدور</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.roles.update', $role) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">اسم الدور <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $role->name) }}"
                                                required>
                                            <small class="text-muted">استخدم أحرف إنجليزية وشرطة سفلية فقط (مثل:
                                                content_manager)</small>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">الصلاحيات</label>
                                            @foreach ($permissions as $model => $modelPermissions)
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="card-title mb-0">
                                                            {{ ucfirst($model) }}
                                                            <span
                                                                class="badge bg-primary ms-2">{{ count($modelPermissions) }}</span>
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach ($modelPermissions as $permissionName => $permission)
                                                                <div class="col-md-3 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="permission_{{ $permission->id }}"
                                                                            name="permissions[]"
                                                                            value="{{ $permission->name }}"
                                                                            {{ in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray())) ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="permission_{{ $permission->id }}">
                                                                            {{ ucfirst(explode('.', $permission->name)[0]) }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @error('permissions')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-secondary">
                                        <i class="ti ti-eye me-1"></i>
                                        عرض
                                    </a>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left me-1"></i>
                                        إلغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-device-floppy me-1"></i>
                                        حفظ التغييرات
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
