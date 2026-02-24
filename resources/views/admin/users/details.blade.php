<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-semibold">الاسم:</label>
            <p class="mb-0">{{ $user->name }}</p>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">اسم المستخدم:</label>
            <p class="mb-0">@{{ $user->username }}</p>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">البريد الإلكتروني:</label>
            <p class="mb-0">{{ $user->email }}</p>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">رقم الهاتف:</label>
            <p class="mb-0">{{ $user->phone ?? 'غير محدد' }}</p>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label fw-semibold">الحالة:</label>
            <p class="mb-0">
                @if($user->status === 'active')
                    <span class="badge bg-success-subtle text-success"><i class="ti ti-check"></i> نشط</span>
                @elseif($user->status === 'inactive')
                    <span class="badge bg-warning-subtle text-warning"><i class="ti ti-clock"></i> غير نشط</span>
                @elseif($user->status === 'suspended')
                    <span class="badge bg-danger-subtle text-danger"><i class="ti ti-ban"></i> معلق</span>
                @endif
            </p>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">الأدوار:</label>
            <p class="mb-0">
                @foreach($user->roles as $role)
                    @if($role->name === 'admin')
                        <span class="badge bg-danger-subtle text-danger">{{ $role->name }}</span>
                    @elseif($role->name === 'driver')
                        <span class="badge bg-primary-subtle text-primary">{{ $role->name }}</span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary">{{ $role->name }}</span>
                    @endif
                @endforeach
            </p>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">تاريخ التسجيل:</label>
            <p class="mb-0">{{ $user->created_at->format('Y-m-d H:i') }}</p>
        </div>
        
        <div class="mb-3">
            <label class="form-label fw-semibold">آخر تسجيل دخول:</label>
            <p class="mb-0">
                @if($user->last_login_at)
                    {{ $user->last_login_at->diffForHumans() }}
                @else
                    <span class="text-muted">لم يسجل دخول</span>
                @endif
            </p>
        </div>
    </div>
</div>

@if($user->hasRole('driver') && $user->driverProfile)
<div class="mt-4">
    <h6 class="fw-semibold mb-3">معلومات السائق</h6>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label fw-semibold">الرقم الوطني:</label>
                <p class="mb-0">{{ $user->driverProfile->national_id }}</p>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">الجنسية:</label>
                <p class="mb-0">{{ $user->driverProfile->nationality }}</p>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label fw-semibold">رقم رخصة القيادة:</label>
                <p class="mb-0">{{ $user->driverProfile->driving_license_number }}</p>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-semibold">تاريخ انتهاء الرخصة:</label>
                <p class="mb-0">
                    @if($user->driverProfile->driving_license_expiry)
                        {{ $user->driverProfile->driving_license_expiry->format('Y-m-d') }}
                        @if($user->driverProfile->driving_license_expiry->isPast())
                            <span class="badge bg-danger-subtle text-danger ms-2">منتهية الصلاحية</span>
                        @elseif($user->driverProfile->driving_license_expiry->diffInDays(now()) <= 30)
                            <span class="badge bg-warning-subtle text-warning ms-2">تنتهي قريباً</span>
                        @endif
                    @else
                        <span class="text-muted">غير محدد</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label fw-semibold">حالة الملف:</label>
        <p class="mb-0">
            @if($user->driverProfile->status === 'approved')
                <span class="badge bg-success-subtle text-success"><i class="ti ti-check"></i> معتمد</span>
            @elseif($user->driverProfile->status === 'pending')
                <span class="badge bg-warning-subtle text-warning"><i class="ti ti-clock"></i> قيد المراجعة</span>
            @elseif($user->driverProfile->status === 'rejected')
                <span class="badge bg-danger-subtle text-danger"><i class="ti ti-x"></i> مرفوض</span>
            @endif
        </p>
    </div>
</div>
@endif

@if($user->vehicles && $user->vehicles->count() > 0)
<div class="mt-4">
    <h6 class="fw-semibold mb-3">المركبات</h6>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>رقم اللوحة</th>
                    <th>الموديل</th>
                    <th>السعة</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->plate_number }}</td>
                    <td>{{ $vehicle->vehicle_model }}</td>
                    <td>{{ $vehicle->capacity }} مقعد</td>
                    <td>
                        @if($vehicle->status === 'active')
                            <span class="badge bg-success-subtle text-success">نشطة</span>
                        @elseif($vehicle->status === 'maintenance')
                            <span class="badge bg-warning-subtle text-warning">صيانة</span>
                        @else
                            <span class="badge bg-danger-subtle text-danger">غير نشطة</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="mt-4 text-center">
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
        <i class="ti ti-edit"></i> تعديل المستخدم
    </a>
    @if($user->hasRole('driver'))
    <a href="{{ route('admin.drivers.show', $user->id) }}" class="btn btn-info btn-sm">
        <i class="ti ti-user-check"></i> ملف السائق
    </a>
    @endif
</div> 