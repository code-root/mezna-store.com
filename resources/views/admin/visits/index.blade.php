@extends('admin.layouts.main')

@section('title', 'إحصائيات الزيارات')

@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">إحصائيات الزيارات</h4>
                <p class="text-muted mb-0">زيارات الأقسام والمنتجات مع المدينة والدولة</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">إجمالي الزيارات</h6>
                        <h3 class="mb-0">{{ number_format($stats['total']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">زيارات الأقسام</h6>
                        <h3 class="mb-0">{{ number_format($stats['by_categories']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">زيارات المنتجات</h6>
                        <h3 class="mb-0">{{ number_format($stats['by_products']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.visits.index') }}" class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">نوع</label>
                        <select name="type" class="form-select">
                            <option value="">الكل</option>
                            <option value="category" {{ request('type') === 'category' ? 'selected' : '' }}>قسم</option>
                            <option value="product" {{ request('type') === 'product' ? 'selected' : '' }}>منتج</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">المدينة</label>
                        <input type="text" name="city" class="form-control" value="{{ request('city') }}" placeholder="المدينة">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">الدولة</label>
                        <input type="text" name="country" class="form-control" value="{{ request('country') }}" placeholder="رمز الدولة">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2"><i class="ti ti-search"></i> بحث</button>
                        <a href="{{ route('admin.visits.index') }}" class="btn btn-outline-secondary">إعادة تعيين</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>النوع</th>
                                <th>القسم / المنتج</th>
                                <th>IP</th>
                                <th>المدينة</th>
                                <th>الدولة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($visits as $visit)
                                <tr>
                                    <td>
                                        @if($visit->visitable_type === \App\Models\Category::class)
                                            <span class="badge bg-info">قسم</span>
                                        @else
                                            <span class="badge bg-success">منتج</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($visit->visitable)
                                            {{ $visit->visitable->name ?? '—' }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td><code>{{ $visit->ip_address ?? '—' }}</code></td>
                                    <td>{{ $visit->city ?? '—' }}</td>
                                    <td>{{ $visit->country_name ?? $visit->country ?? '—' }}</td>
                                    <td>{{ $visit->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">لا توجد زيارات مسجلة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($visits->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $visits->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
