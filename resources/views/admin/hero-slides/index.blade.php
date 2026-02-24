@extends('admin.layouts.main')
@section('title', 'صور الهيرو (الكاروسيل)')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">صور الهيرو</h4>
                <p class="text-muted mb-0">صور تظهر في بداية الموقع بشكل عشوائي</p>
            </div>
            <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary"><i class="ti ti-plus"></i> إضافة صورة</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-centered table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الصورة</th>
                                <th>Alt / Caption</th>
                                <th>ترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($slides as $slide)
                                <tr>
                                    <td>{{ $slide->id }}</td>
                                    <td>
                                        <img src="{{ $slide->image }}" alt="{{ $slide->alt_text }}" style="max-height:48px; border-radius:6px;">
                                    </td>
                                    <td>
                                        @if($slide->alt_text || $slide->caption)
                                            <small><strong>Alt:</strong> {{ Str::limit($slide->alt_text, 30) }}</small><br>
                                            <small class="text-muted">{{ Str::limit($slide->caption, 30) }}</small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $slide->sort_order }}</td>
                                    <td>{{ $slide->is_active ? 'مفعل' : 'غير مفعل' }}</td>
                                    <td>
                                        <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-soft-secondary">تعديل</a>
                                        <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide) }}" class="d-inline" onsubmit="return confirm('حذف هذه الصورة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">لا توجد صور. <a href="{{ route('admin.hero-slides.create') }}">إضافة صورة</a></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($slides->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $slides->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
