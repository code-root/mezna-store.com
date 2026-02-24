@extends('admin.layouts.main')

@section('title', 'تعديل البانر')

@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2 mb-4">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">تعديل البانر</h4>
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
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">رابط الصورة</label>
                            <input type="url" name="image" class="form-control"
                                value="{{ old('image', $banner->image) }}" required>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">القسم (اختياري)</label>
                            <select name="category_id" class="form-select">
                                <option value="">اختر القسم (اختياري)</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $banner->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الحالة</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ old('is_active', $banner->is_active) == 1 ? 'selected' : '' }}>
                                    مفعل</option>
                                <option value="0" {{ old('is_active', $banner->is_active) == 0 ? 'selected' : '' }}>
                                    غير مفعل</option>
                            </select>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
