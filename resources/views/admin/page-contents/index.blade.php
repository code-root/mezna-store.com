@extends('admin.layouts.main')
@section('title', 'محتوى الصفحات')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">محتوى الصفحات</h4>
                <p class="text-muted mb-0">تعديل نصوص الشحن، الاسترجاع، الأسئلة الشائعة، وبيكسل ميتا</p>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">الشحن (Shipping)</h5>
                        <p class="text-muted small">{{ Str::limit(optional($items['shipping'])->content ?? '—', 60) }}</p>
                        <a href="{{ route('admin.page-contents.edit', 'shipping') }}" class="btn btn-sm btn-primary">تعديل</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">الاسترجاع (Returns)</h5>
                        <p class="text-muted small">{{ Str::limit(optional($items['returns'])->content ?? '—', 60) }}</p>
                        <a href="{{ route('admin.page-contents.edit', 'returns') }}" class="btn btn-sm btn-primary">تعديل</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">الأسئلة الشائعة (FAQ)</h5>
                        <p class="text-muted small">{{ Str::limit(optional($items['faq'])->content ?? '—', 60) }}</p>
                        <a href="{{ route('admin.page-contents.edit', 'faq') }}" class="btn btn-sm btn-primary">تعديل</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">معرف بيكسل ميتا</h5>
                        <p class="text-muted small">{{ optional($items['meta_pixel_id'])->content ?? 'غير مضبوط' }}</p>
                        <a href="{{ route('admin.page-contents.edit', 'meta_pixel_id') }}" class="btn btn-sm btn-primary">تعديل</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">الصفحة الرئيسية (SEO)</h5>
                        <p class="text-muted small">{{ optional($items['home'])->title ?: '—' }}</p>
                        <a href="{{ route('admin.page-contents.edit', 'home') }}" class="btn btn-sm btn-primary">تعديل SEO</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
