@extends('admin.layouts.main')
@section('title', 'تعديل الملف الشخصي')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">تعديل الملف الشخصي</h4>
                    <p class="text-muted mb-0">تحديث معلوماتك الشخصية</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">الملف الشخصي</a></li>
                        <li class="breadcrumb-item active">تعديل</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">معلومات الحساب</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                <i class="ti ti-user me-1"></i>
                                                الاسم الكامل <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $user->name) }}"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                <i class="ti ti-mail me-1"></i>
                                                البريد الإلكتروني <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', $user->email) }}"
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                سيتم استخدام هذا البريد للإشعارات والاستعادة
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">معلومات إضافية</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-control-plaintext">
                                                    <strong>تاريخ التسجيل:</strong>
                                                    {{ $user->created_at->format('Y/m/d') }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-control-plaintext">
                                                    <strong>آخر تحديث:</strong>
                                                    {{ $user->updated_at->format('Y/m/d H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('admin.profile') }}" class="btn btn-secondary">
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

                <div class="col-xl-4">
                    <!-- Profile Preview -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">معاينة الملف الشخصي</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="avatar-lg mx-auto mb-3">
                                <span class="avatar-title bg-primary text-white rounded-circle fs-24">
                                    <i class="ti ti-user"></i>
                                </span>
                            </div>
                            <h5 class="mb-1" id="preview-name">{{ $user->name }}</h5>
                            <p class="text-muted mb-0" id="preview-email">{{ $user->email }}</p>

                            <hr class="my-3">

                            <div class="d-flex justify-content-center gap-2">
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Security Tips -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">نصائح الأمان</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-2">
                                    <i class="ti ti-check text-success me-1"></i>
                                    استخدم كلمة مرور قوية تحتوي على أحرف وأرقام
                                </li>
                                <li class="mb-2">
                                    <i class="ti ti-check text-success me-1"></i>
                                    لا تشارك معلومات الدخول مع أي شخص
                                </li>
                                <li class="mb-2">
                                    <i class="ti ti-check text-success me-1"></i>
                                    غير كلمة المرور بانتظام
                                </li>
                                <li class="mb-0">
                                    <i class="ti ti-check text-success me-1"></i>
                                    تأكد من تسجيل الخروج عند الانتهاء
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update preview when form fields change
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const previewName = document.getElementById('preview-name');
            const previewEmail = document.getElementById('preview-email');

            function updatePreview() {
                previewName.textContent = nameInput.value || '{{ $user->name }}';
                previewEmail.textContent = emailInput.value || '{{ $user->email }}';
            }

            nameInput.addEventListener('input', updatePreview);
            emailInput.addEventListener('input', updatePreview);
        });
    </script>
@endpush
