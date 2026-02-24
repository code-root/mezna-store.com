@extends('admin.layouts.main')

@section('title', 'إضافة قسم جديد')

@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">إضافة قسم جديد</h4>
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
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">اسم القسم</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">رابط صورة القسم</label>
                        <input type="url" name="image" class="form-control" value="{{ old('image') }}" placeholder="https://...">
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الحالة</label>
                        <select name="is_active" class="form-select" required>
                            <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>مفعل</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>غير مفعل</option>
                        </select>
                        @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="hide_price" value="1" class="form-check-input" id="hide_price" {{ old('hide_price') ? 'checked' : '' }}>
                            <label class="form-check-label" for="hide_price">إخفاء السعر في هذا القسم (عرض بدون سعر)</label>
                        </div>
                        @error('hide_price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
