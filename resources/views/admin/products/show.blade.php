@extends('admin.layouts.main')

@section('title', 'عرض المنتج')

@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2 mb-4">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">عرض المنتج: {{ $product->name }}</h4>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid mb-3"
                            style="max-width:200px;">
                    </div>
                    <p><strong>الاسم:</strong> {{ $product->name }}</p>
                    <p><strong>القسم:</strong> {{ $product->category->name ?? '-' }}</p>
                    <p><strong>السعر:</strong> {{ number_format($product->price, 2) }} $</p>
                    <p><strong>الوصف:</strong> {{ $product->description ?? '-' }}</p>
                    <p><strong>الحالة:</strong>
                        @if ($product->is_active)
                            <span class="badge bg-success"><i class="ti ti-check me-1"></i> مفعل</span>
                        @else
                            <span class="badge bg-secondary"><i class="ti ti-pause me-1"></i> غير مفعل</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Variants Section -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="fs-15 text-uppercase fw-bold mb-0">المتغيرات (Variants)</h5>
                <a href="{{ route('admin.products.variants.create', $product) }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> إضافة عنصر  
                </a>
            </div>

            <!-- Filter by Name -->
            <div class="mb-3">
                <form method="GET" action="{{ route('admin.products.show', $product) }}" class="d-flex gap-2">
                    <input type="text" name="variant_name" class="form-control form-control-sm" placeholder="بحث بالاسم..." value="{{ request('variant_name') }}">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-search"></i> بحث</button>
                </form>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>الصورة</th>
                                    <th>الاسم</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($product->variants as $variant)
                                    <tr>
                                        <td>
                                            <img src="{{ $variant->image }}" alt="{{ $variant->name }}" width="50" height="50" class="rounded">
                                        </td>
                                        <td>{{ $variant->name }}</td>
                                        <td>
                                            @if($variant->is_active)
                                                <span class="badge bg-success"><i class="ti ti-check me-1"></i> مفعل</span>
                                            @else
                                                <span class="badge bg-secondary"><i class="ti ti-pause me-1"></i> غير مفعل</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.products.variants.edit', [$product, $variant]) }}" class="btn btn-sm btn-soft-secondary" title="تعديل"><i class="ti ti-edit"></i></a>
                                                <form action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المتغير؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-soft-danger" title="حذف"><i class="ti ti-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ti ti-box text-muted display-4"></i>
                                                <h5 class="mt-2">لا توجد متغيرات</h5>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
