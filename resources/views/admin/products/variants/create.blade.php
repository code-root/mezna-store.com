@extends('admin.layouts.main')

@section('title', 'إضافة متغير للمنتج')

@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2 mb-4">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">إضافة متغير لمنتج: {{ $product->name }}</h4>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.products.variants.store', $product) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">اسم المتغير</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">رابط الصورة</label>
                            <input type="url" name="image" class="form-control" value="{{ old('image') }}" required>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">رابط الصورة في Google</label>
                            <input type="url" name="google_photo_link" class="form-control" value="{{ old('google_photo_link') }}" required>
                            @error('google_photo_link')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الحالة</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>مفعل</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>غير مفعل</option>
                            </select>
                            @error('is_active')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-secondary">إلغاء</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
