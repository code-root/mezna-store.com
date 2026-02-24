@extends('admin.layouts.main')
@section('title', 'الإعدادات')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">إعدادات النظام</h4>
                    <p class="text-muted mb-0">تعديل إعدادات التطبيق والاتصال</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item active">الإعدادات</li>
                    </ol>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-circle me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-circle me-1"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">إعدادات النظام</h5>
                            <small class="text-muted">تعديل الإعدادات الأساسية للتطبيق</small>
                        </div>
                        <div>
                            <a href="{{ route('admin.settings.manage') }}" class="btn btn-secondary">
                                <i class="ti ti-settings-cog"></i> إدارة متقدمة
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8">
                    <!-- إعدادات التطبيق -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="header-title mb-0">إعدادات التطبيق</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="app_name" class="form-label">اسم التطبيق</label>
                                    <input type="text" class="form-control" id="app_name" name="app_name"
                                        value="{{ old('app_name', $appSettings['app_name']) }}" required>
                                    <div class="form-text">اسم التطبيق الذي سيظهر في العنوان والهيدر</div>
                                </div>

                                <div class="mb-3">
                                    <label for="app_description" class="form-label">وصف التطبيق</label>
                                    <textarea class="form-control" id="app_description" name="app_description" rows="3">{{ old('app_description', $appSettings['app_description']) }}</textarea>
                                    <div class="form-text">وصف مختصر للتطبيق</div>
                                </div>

                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">البريد الإلكتروني للاتصال</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email"
                                        value="{{ old('contact_email', $appSettings['contact_email']) }}" required>
                                    <div class="form-text">البريد الإلكتروني الرئيسي للاتصال</div>
                                </div>

                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">رقم الهاتف للاتصال</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                        value="{{ old('contact_phone', $appSettings['contact_phone']) }}">
                                    <div class="form-text">رقم الهاتف الرئيسي للاتصال</div>
                                </div>

                                <div class="mb-3">
                                    <label for="support_email" class="form-label">بريد الدعم الفني</label>
                                    <input type="email" class="form-control" id="support_email" name="support_email"
                                        value="{{ old('support_email', $appSettings['support_email']) }}">
                                    <div class="form-text">البريد الإلكتروني للدعم الفني</div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy"></i> حفظ الإعدادات
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- إعدادات النظام -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="header-title mb-0">إعدادات النظام</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.system') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">اللغة الافتراضية</label>
                                            <select name="default_language" class="form-select">
                                                <option value="ar"
                                                    {{ $systemSettings['default_language'] == 'ar' ? 'selected' : '' }}>
                                                    العربية</option>
                                                <option value="en"
                                                    {{ $systemSettings['default_language'] == 'en' ? 'selected' : '' }}>
                                                    English</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">المنطقة الزمنية</label>
                                            <select name="timezone" class="form-select">
                                                <option value="Asia/Riyadh"
                                                    {{ $systemSettings['timezone'] == 'Asia/Riyadh' ? 'selected' : '' }}>
                                                    الرياض (GMT+3)</option>
                                                <option value="Asia/Dubai"
                                                    {{ $systemSettings['timezone'] == 'Asia/Dubai' ? 'selected' : '' }}>دبي
                                                    (GMT+4)</option>
                                                <option value="Asia/Kuwait"
                                                    {{ $systemSettings['timezone'] == 'Asia/Kuwait' ? 'selected' : '' }}>
                                                    الكويت (GMT+3)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">العملة</label>
                                            <select name="currency" class="form-select">
                                                <option value="SAR"
                                                    {{ $systemSettings['currency'] == 'SAR' ? 'selected' : '' }}>الريال
                                                    السعودي (SAR)</option>
                                                <option value="AED"
                                                    {{ $systemSettings['currency'] == 'AED' ? 'selected' : '' }}>الدرهم
                                                    الإماراتي (AED)</option>
                                                <option value="KWD"
                                                    {{ $systemSettings['currency'] == 'KWD' ? 'selected' : '' }}>الدينار
                                                    الكويتي (KWD)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">تنسيق التاريخ</label>
                                            <select name="date_format" class="form-select">
                                                <option value="Y-m-d"
                                                    {{ $systemSettings['date_format'] == 'Y-m-d' ? 'selected' : '' }}>
                                                    YYYY-MM-DD</option>
                                                <option value="d/m/Y"
                                                    {{ $systemSettings['date_format'] == 'd/m/Y' ? 'selected' : '' }}>
                                                    DD/MM/YYYY</option>
                                                <option value="m/d/Y"
                                                    {{ $systemSettings['date_format'] == 'm/d/Y' ? 'selected' : '' }}>
                                                    MM/DD/YYYY</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-secondary">
                                    <i class="ti ti-device-floppy"></i> حفظ إعدادات النظام
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <!-- معلومات النظام -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="header-title mb-0">معلومات النظام</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">إصدار Laravel:</label>
                                <p class="mb-0">{{ app()->version() }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">إصدار PHP:</label>
                                <p class="mb-0">{{ PHP_VERSION }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">بيئة التشغيل:</label>
                                <p class="mb-0">
                                    @if (app()->environment('production'))
                                        <span class="badge bg-success-subtle text-success">الإنتاج</span>
                                    @elseif(app()->environment('staging'))
                                        <span class="badge bg-warning-subtle text-warning">الاختبار</span>
                                    @else
                                        <span class="badge bg-info-subtle text-info">التطوير</span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">وقت التشغيل:</label>
                                <p class="mb-0">{{ now()->diffForHumans() }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">مساحة التخزين:</label>
                                <p class="mb-0">
                                    @php
                                        $disk = Storage::disk('local');
                                        $totalSpace = disk_total_space(storage_path());
                                        $freeSpace = disk_free_space(storage_path());
                                        $usedSpace = $totalSpace - $freeSpace;
                                        $usagePercentage = round(($usedSpace / $totalSpace) * 100, 1);
                                    @endphp
                                    {{ number_format($usedSpace / 1024 / 1024 / 1024, 2) }} GB /
                                    {{ number_format($totalSpace / 1024 / 1024 / 1024, 2) }} GB
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar" style="width: {{ $usagePercentage }}%"></div>
                                </div>
                                <small class="text-muted">{{ $usagePercentage }}% مستخدم</small>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- إعدادات الأمان -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="header-title mb-0">إعدادات الأمان</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.security') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode"
                                            name="maintenance_mode"
                                            {{ $securitySettings['maintenance_mode'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            وضع الصيانة
                                        </label>
                                    </div>
                                    <small class="text-muted">إيقاف التطبيق مؤقتاً للصيانة</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="debug_mode"
                                            name="debug_mode" {{ $securitySettings['debug_mode'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="debug_mode">
                                            وضع التصحيح
                                        </label>
                                    </div>
                                    <small class="text-muted">عرض رسائل الخطأ التفصيلية</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="force_https"
                                            name="force_https" {{ $securitySettings['force_https'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="force_https">
                                            إجبار HTTPS
                                        </label>
                                    </div>
                                    <small class="text-muted">إجبار استخدام الاتصال الآمن</small>
                                </div>

                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="ti ti-shield-check"></i> حفظ إعدادات الأمان
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- النسخ الاحتياطي -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="header-title mb-0">النسخ الاحتياطي</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $backupsPath = storage_path('backups');
                                $latestBackup = null;
                                $backupSize = 0;

                                if (file_exists($backupsPath)) {
                                    $backups = glob($backupsPath . '/*.sql');
                                    if (!empty($backups)) {
                                        $latestBackup = basename(end($backups));
                                        $backupSize = filesize(end($backups));
                                    }
                                }

                                // Calculate database size
                                $dbSize = 0;
                                try {
                                    $tables = \DB::select('SHOW TABLE STATUS');
                                    foreach ($tables as $table) {
                                        $dbSize += $table->Data_length + $table->Index_length;
                                    }
                                } catch (\Exception $e) {
                                    $dbSize = 0;
                                }
                            @endphp

                            <div class="mb-3">
                                <label class="form-label fw-semibold">آخر نسخة احتياطية:</label>
                                <p class="mb-0">
                                    @if ($latestBackup)
                                        <span class="text-success">{{ $latestBackup }}</span>
                                        <br><small class="text-muted">{{ number_format($backupSize / 1024 / 1024, 2) }}
                                            MB</small>
                                    @else
                                        <span class="text-muted">لم يتم إنشاء نسخة احتياطية بعد</span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">حجم قاعدة البيانات:</label>
                                <p class="mb-0">{{ number_format($dbSize / 1024 / 1024, 2) }} MB</p>
                            </div>

                            <form action="{{ route('admin.settings.backup') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm me-2">
                                    <i class="ti ti-download"></i> إنشاء نسخة احتياطية
                                </button>
                            </form>

                            <button type="button" class="btn btn-secondary btn-sm"
                                onclick="alert('سيتم إضافة هذه الميزة قريباً')">
                                <i class="ti ti-upload"></i> استعادة نسخة احتياطية
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
