@extends('admin.layouts.main')
@section('title', 'سجل الأنشطة')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">سجل الأنشطة</h4>
                    <p class="text-muted mb-0">مراجعة جميع أنشطتك في النظام</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">الملف الشخصي</a></li>
                        <li class="breadcrumb-item active">الأنشطة</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">سجل الأنشطة الأخيرة</h5>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-filter me-1"></i>
                                    فلترة
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">جميع الأنشطة</a></li>
                                    <li><a class="dropdown-item" href="#">تسجيلات الدخول</a></li>
                                    <li><a class="dropdown-item" href="#">العمليات على البريد</a></li>
                                    <li><a class="dropdown-item" href="#">تغييرات الملف الشخصي</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                @forelse($activities as $activity)
                                    <div class="timeline-item">
                                        <div
                                            class="timeline-marker {{ $activity['action'] === 'تسجيل الدخول' ? 'bg-success' : ($activity['action'] === 'إنشاء بريد إلكتروني' ? 'bg-primary' : 'bg-info') }}">
                                        </div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="timeline-title mb-1">{{ $activity['action'] }}</h6>
                                                    <p class="timeline-text text-muted mb-1">{{ $activity['details'] }}</p>
                                                    <small class="text-muted">
                                                        <i class="ti ti-map-pin me-1"></i>
                                                        IP: {{ $activity['ip'] }}
                                                    </small>
                                                </div>
                                                <small class="text-muted timeline-date">
                                                    {{ $activity['date']->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <div class="avatar-lg mx-auto mb-3">
                                            <span class="avatar-title bg-light text-muted rounded-circle">
                                                <i class="ti ti-history-off fs-24"></i>
                                            </span>
                                        </div>
                                        <h5 class="text-muted">لا توجد أنشطة</h5>
                                        <p class="text-muted">لم يتم تسجيل أي أنشطة حتى الآن</p>
                                    </div>
                                @endforelse
                            </div>

                            @if (count($activities) > 0)
                                <div class="text-center mt-4">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="ti ti-refresh me-1"></i>
                                        تحميل المزيد
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Statistics -->
            <div class="row mt-4">
                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-2">
                                <span class="avatar-title bg-success text-white rounded">
                                    <i class="ti ti-login"></i>
                                </span>
                            </div>
                            <h4 class="mb-1">{{ collect($activities)->where('action', 'تسجيل الدخول')->count() }}</h4>
                            <p class="text-muted mb-0">تسجيلات الدخول</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-2">
                                <span class="avatar-title bg-primary text-white rounded">
                                    <i class="ti ti-mail-plus"></i>
                                </span>
                            </div>
                            <h4 class="mb-1">{{ collect($activities)->where('action', 'إنشاء بريد إلكتروني')->count() }}
                            </h4>
                            <p class="text-muted mb-0">إنشاء بريد</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-2">
                                <span class="avatar-title bg-info text-white rounded">
                                    <i class="ti ti-user-edit"></i>
                                </span>
                            </div>
                            <h4 class="mb-1">{{ collect($activities)->where('action', 'تحديث الملف الشخصي')->count() }}
                            </h4>
                            <p class="text-muted mb-0">تحديثات الملف</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-2">
                                <span class="avatar-title bg-warning text-white rounded">
                                    <i class="ti ti-activity"></i>
                                </span>
                            </div>
                            <h4 class="mb-1">{{ count($activities) }}</h4>
                            <p class="text-muted mb-0">إجمالي الأنشطة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-marker {
            position: absolute;
            left: -22px;
            top: 5px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #e9ecef;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 3px solid #dee2e6;
        }

        .timeline-title {
            color: #495057;
            margin-bottom: 5px;
        }

        .timeline-date {
            white-space: nowrap;
            font-size: 0.875rem;
        }
    </style>
@endsection
