@extends('admin.layouts.main')
@section('title', 'تعديل: ' . ($labels[$key] ?? $key))
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">{{ $labels[$key] ?? $key }}</h4>
            </div>
            <a href="{{ route('admin.page-contents.index') }}" class="btn btn-outline-secondary">العودة</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('admin.page-contents.update', $key) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- المحتوى الرئيسي (ما عدا الصفحة الرئيسية) --}}
            @if($key !== 'home')
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">المحتوى</h5>
                    </div>
                    <div class="card-body">
                        @if($key === 'meta_pixel_id')
                            <div class="mb-0">
                                <label class="form-label">معرف البيكسل (Pixel ID)</label>
                                <input type="text" name="content" class="form-control" value="{{ old('content', $item->content) }}" placeholder="مثال: 1234567890123456">
                                <small class="text-muted">من لوحة إعلانات ميتا → إعدادات البيانات → البيكسل</small>
                            </div>
                        @else
                            <div class="mb-0">
                                <label class="form-label">نص الصفحة</label>
                                <textarea name="content" class="form-control" rows="10">{{ old('content', $item->content) }}</textarea>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <input type="hidden" name="content" value="">
            @endif

            {{-- إعدادات SEO --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0"><i class="ti ti-search me-1"></i> إعدادات SEO</h5>
                    <small class="text-muted">Title, Meta Description, Open Graph</small>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">عنوان الصفحة (Title)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $item->title) }}" placeholder="يظهر في تبويب المتصفح ومحركات البحث" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">وصف Meta (Meta Description)</label>
                        <textarea name="meta_description" class="form-control" rows="2" maxlength="500" placeholder="وصف مختصر يظهر في نتائج البحث">{{ old('meta_description', $item->meta_description) }}</textarea>
                        <small class="text-muted">يفضل 150–160 حرفاً</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">كلمات مفتاحية (Meta Keywords)</label>
                        <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $item->meta_keywords) }}" placeholder="كلمة1, كلمة2, كلمة3" maxlength="500">
                    </div>
                    <hr>
                    <h6 class="text-muted mb-3">Open Graph (لمشاركة الصفحة على مواقع التواصل)</h6>
                    <div class="mb-3">
                        <label class="form-label">og:title</label>
                        <input type="text" name="og_title" class="form-control" value="{{ old('og_title', $item->og_title) }}" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">og:description</label>
                        <textarea name="og_description" class="form-control" rows="2" maxlength="500">{{ old('og_description', $item->og_description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">og:image (رابط صورة للمشاركة)</label>
                        <input type="url" name="og_image" class="form-control" value="{{ old('og_image', $item->og_image) }}" placeholder="https://...">
                        @if($item->og_image ?? null)
                            <div class="mt-2"><img src="{{ $item->og_image }}" alt="" style="max-height:80px; border-radius:6px;"></div>
                        @endif
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> حفظ</button>
            <a href="{{ route('admin.page-contents.index') }}" class="btn btn-outline-secondary">إلغاء</a>
        </form>
    </div>
</div>
@endsection
