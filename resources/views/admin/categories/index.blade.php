@extends('admin.layouts.main')

@section('title', 'إدارة الأقسام')

@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">إدارة الأقسام</h4>
                <p class="text-muted mb-0">عرض وإدارة جميع الأقسام في النظام</p>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item active">الأقسام</li>
                </ol>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">الحالة</label>
                        <select name="is_active" class="form-select">
                            <option value="">جميع الأقسام</option>
                            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">البحث</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="ابحث في اسم القسم..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ti ti-search me-1"></i> بحث
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-refresh me-1"></i> إعادة تعيين
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> إضافة قسم جديد
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Categories Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الاسم</th>
                                <th>الصورة</th>
                                <th>إخفاء السعر</th>
                                <th>الحالة</th>
                                <th>عدد المنتجات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if($category->image)
                                            <img src="{{ $category->image }}" alt="" style="max-height:36px; border-radius:4px;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->hide_price ? 'نعم' : 'لا' }}</td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge bg-success"><i class="ti ti-check me-1"></i> مفعل</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="ti ti-pause me-1"></i> غير مفعل</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->products()->count() }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-soft-primary" title="عرض">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-soft-secondary" title="تعديل">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" title="حذف">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ti ti-category text-muted display-1"></i>
                                            <h5 class="mt-3">لا توجد أقسام</h5>
                                            <p>لم يتم العثور على أي أقسام في النظام</p>
                                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                                <i class="ti ti-plus me-1"></i> إضافة قسم جديد
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($categories->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $categories->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
