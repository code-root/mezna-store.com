@extends('admin.layouts.main')
@section('title', 'تعديل صورة هيرو')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">تعديل صورة هيرو</h4>
            </div>
            <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-outline-secondary">العودة</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.hero-slides.update', $slide) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">رابط الصورة</label>
                        <input type="url" name="image" class="form-control" value="{{ old('image', $slide->image) }}" required>
                        @if($slide->image)
                            <div class="mt-2"><img src="{{ $slide->image }}" alt="{{ $slide->alt_text }}" style="max-height:120px; border-radius:8px;"></div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نص بديل (Alt) للـ SEO</label>
                        <input type="text" name="alt_text" class="form-control" value="{{ old('alt_text', $slide->alt_text) }}" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">التسمية (Caption)</label>
                        <input type="text" name="caption" class="form-control" value="{{ old('caption', $slide->caption) }}" maxlength="500">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ترتيب العرض</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slide->sort_order) }}" min="0">
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $slide->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">مفعل</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
