@extends('admin.layouts.main')

@section('title', 'عرض القسم')

@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2 mb-4">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">عرض القسم: {{ $category->name }}</h4>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    @if($category->image)
                        <p class="mb-2"><strong>صورة القسم:</strong><br>
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" style="max-height:120px; border-radius:8px;">
                        </p>
                    @endif
                    <p><strong>الاسم:</strong> {{ $category->name }}</p>
                    <p><strong>الحالة:</strong>
                        @if ($category->is_active)
                            <span class="badge bg-success"><i class="ti ti-check me-1"></i> مفعل</span>
                        @else
                            <span class="badge bg-secondary"><i class="ti ti-pause me-1"></i> غير مفعل</span>
                        @endif
                    </p>
                    <p><strong>إخفاء السعر:</strong> {{ $category->hide_price ? 'نعم' : 'لا' }}</p>
                    <p><strong>عدد المنتجات:</strong> {{ $category->products()->count() }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">المنتجات المرتبطة</h5>
                </div>
                <div class="card-body">
                    @if ($category->products->count())
                        <ul class="list-group">
                            @foreach ($category->products as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $product->name }}
                                    @if ($product->is_active)
                                        <span class="badge bg-success">مفعل</span>
                                    @else
                                        <span class="badge bg-secondary">غير مفعل</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">لا توجد منتجات مرتبطة بهذا القسم.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
