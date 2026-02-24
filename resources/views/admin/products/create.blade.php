@extends('admin.layouts.main')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">إضافة منتج جديد</h4>
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
                <form action="{{ route('admin.products.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">اسم المنتج</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">القسم</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">اختر القسم</option>
                            @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">السعر</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                            step="0.01" required>
                        @error('price')
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
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
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
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection