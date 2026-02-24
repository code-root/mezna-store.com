@extends('admin.layouts.main')

@section('title', 'عرض البانر')

@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2 mb-4">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">عرض البانر</h4>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{ $banner->image }}" alt="Banner" class="img-fluid mb-3" style="max-width:300px;">
                    </div>
                    <p><strong>القسم:</strong> {{ $banner->category->name ?? '-' }}</p>
                    <p><strong>الحالة:</strong>
                        @if ($banner->is_active)
                            <span class="badge bg-success"><i class="ti ti-check me-1"></i> مفعل</span>
                        @else
                            <span class="badge bg-secondary"><i class="ti ti-pause me-1"></i> غير مفعل</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
