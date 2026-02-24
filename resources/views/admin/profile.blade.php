@extends('admin.layouts.main')
@section('title', 'الملف الشخصي')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">الملف الشخصي</h4>
                    <p class="text-muted mb-0">إدارة معلوماتك الشخصية وإعدادات الحساب</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">الملف الشخصي</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <!-- Profile Information -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">المعلومات الشخصية</h5>
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-edit me-1"></i>
                                تعديل
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">الاسم الكامل</label>
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
                                        <label class="form-label fw-semibold">تاريخ التسجيل</label>
                                        <p class="form-control-plaintext">{{ $user->created_at->format('Y/m/d') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">آخر نشاط</label>
                                        <p class="form-control-plaintext">{{ $user->updated_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Roles and Permissions -->
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">الأدوار والصلاحيات</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-primary">{{ $role->name }}</span>
                                        @endforeach
                                        @if ($user->permissions->count() > 0)
                                            <span class="badge bg-info">{{ $user->permissions->count() }} صلاحية</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Statistics -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">إحصائيات الحساب</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 col-6">
                                    <div class="border-end border-light">
                                        <h4 class="text-primary mb-1">{{ $stats['account_age_days'] }}</h4>
                                        <small class="text-muted">يوم منذ التسجيل</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="border-end border-light">
                                        <h4 class="text-success mb-1">{{ $stats['total_logins'] }}</h4>
                                        <small class="text-muted">تسجيل دخول</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="border-end border-light">
                                        <h4 class="text-info mb-1">{{ $stats['roles_count'] }}</h4>
                                        <small class="text-muted">الأدوار</small>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <h4 class="text-warning mb-1">{{ $stats['permissions_count'] }}</h4>
                                    <small class="text-muted">الصلاحيات</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Actions -->
                <div class="col-xl-4">
                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">الإجراءات السريعة</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-primary">
                                    <i class="ti ti-edit me-1"></i>
                                    تعديل المعلومات
                                </a>

                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal">
                                    <i class="ti ti-key me-1"></i>
                                    تغيير كلمة المرور
                                </button>

                                <a href="{{ route('admin.profile.activity') }}" class="btn btn-outline-info">
                                    <i class="ti ti-history me-1"></i>
                                    سجل الأنشطة
                                </a>

                                <hr>

                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#logoutModal">
                                    <i class="ti ti-logout me-1"></i>
                                    تسجيل الخروج
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">حالة الحساب</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti ti-circle-filled text-success me-2"></i>
                                <span>الحساب نشط</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti ti-shield-check text-info me-2"></i>
                                <span>آمن ومحمي</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-mail-check text-primary me-2"></i>
                                <span>البريد مُفعل</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">تغيير كلمة المرور</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.profile.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)">
                            <div class="form-text">
                                يجب أن تحتوي على حرف كبير وصغير ورقم ورمز خاص على الأقل
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">تغيير كلمة المرور</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">تأكيد تسجيل الخروج</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من أنك تريد تسجيل الخروج من النظام؟</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
