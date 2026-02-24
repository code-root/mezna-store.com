@extends('admin.layouts.main')
@section('title', 'إدارة الإعدادات المتقدمة')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">إدارة الإعدادات المتقدمة</h4>
                <p class="text-muted mb-0">إضافة وتعديل إعدادات النظام المخصصة</p>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.settings.index') }}">الإعدادات</a></li>
                    <li class="breadcrumb-item active">إدارة متقدمة</li>
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

        <!-- Action Buttons -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">قائمة الإعدادات</h5>
                        <small class="text-muted">إجمالي الإعدادات: {{ $settings->total() ?? 0 }}</small>
                    </div>
                    <div>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary me-2">
                            <i class="ti ti-arrow-left"></i> العودة للإعدادات العامة
                        </a>
                        <a href="{{ route('admin.settings.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i> إضافة إعداد جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.settings.manage') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">البحث</label>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                            placeholder="البحث في مفاتيح الإعدادات">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">المجموعة</label>
                        <select name="group" class="form-select">
                            <option value="">جميع المجموعات</option>
                            @foreach($groups as $group)
                                <option value="{{ $group }}" {{ request('group') == $group ? 'selected' : '' }}>
                                    {{ ucfirst($group) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">النوع</label>
                        <select name="type" class="form-select">
                            <option value="">جميع الأنواع</option>
                            <option value="string" {{ request('type') == 'string' ? 'selected' : '' }}>نص</option>
                            <option value="integer" {{ request('type') == 'integer' ? 'selected' : '' }}>رقم صحيح</option>
                            <option value="decimal" {{ request('type') == 'decimal' ? 'selected' : '' }}>رقم عشري</option>
                            <option value="boolean" {{ request('type') == 'boolean' ? 'selected' : '' }}>منطقي</option>
                            <option value="json" {{ request('type') == 'json' ? 'selected' : '' }}>JSON</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-search"></i> بحث
                            </button>
                            <a href="{{ route('admin.settings.manage') }}" class="btn btn-secondary">
                                <i class="ti ti-refresh"></i> إعادة تعيين
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Settings Table -->
        <div class="card">
            <div class="card-body">
                @if($settings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>المفتاح</th>
                                <th>القيمة</th>
                                <th>النوع</th>
                                <th>المجموعة</th>
                                <th>عام</th>
                                <th>قابل للتعديل</th>
                                <th>الوصف</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $setting)
                            <tr>
                                <td>
                                    <code class="text-primary">{{ $setting->setting_key }}</code>
                                </td>
                                <td>
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                        @if($setting->setting_type === 'boolean')
                                            <span class="badge bg-{{ $setting->setting_value == '1' ? 'success' : 'secondary' }}">
                                                {{ $setting->setting_value == '1' ? 'نعم' : 'لا' }}
                                            </span>
                                        @elseif($setting->setting_type === 'json')
                                            <code class="text-muted">{{ Str::limit($setting->setting_value, 50) }}</code>
                                        @else
                                            {{ Str::limit($setting->setting_value, 50) }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $setting->setting_type }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $setting->group }}</span>
                                </td>
                                <td>
                                    @if($setting->is_public)
                                        <span class="badge bg-success">نعم</span>
                                    @else
                                        <span class="badge bg-warning">لا</span>
                                    @endif
                                </td>
                                <td>
                                    @if($setting->is_editable)
                                        <span class="badge bg-success">نعم</span>
                                    @else
                                        <span class="badge bg-danger">لا</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($setting->description, 40) }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($setting->is_editable)
                                            <a href="{{ route('admin.settings.edit', $setting) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="تحرير">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.settings.destroy', $setting) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الإعداد؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="حذف">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    disabled 
                                                    title="غير قابل للتعديل">
                                                <i class="ti ti-lock"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            عرض {{ $settings->firstItem() ?? 0 }} إلى {{ $settings->lastItem() ?? 0 }} 
                            من أصل {{ $settings->total() ?? 0 }} إعداد
                        </small>
                    </div>
                    <div>
                        {{ $settings->links() }}
                    </div>
                </div>
                @else
                <div class="text-center py-4">
                    <div class="mb-3">
                        <i class="ti ti-settings fs-48 text-muted"></i>
                    </div>
                    <h5 class="text-muted">لا توجد إعدادات</h5>
                    <p class="text-muted">لم يتم العثور على أي إعدادات مطابقة للبحث.</p>
                    <a href="{{ route('admin.settings.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i> إضافة إعداد جديد
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    color: #fff;
}
.table td {
    vertical-align: middle;
    font-size: 0.875rem;
}
.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-left: 2px;
}
.badge {
    font-size: 0.75rem;
}
code {
    font-size: 0.8rem;
    background-color: #f8f9fa;
    color: #e83e8c;
    padding: 2px 4px;
    border-radius: 3px;
}
</style>
@endpush
