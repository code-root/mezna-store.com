@extends('admin.layouts.main')
@section('title', 'حسابات التواصل الاجتماعي')
@section('content')
<div class="page-content">
    <div class="page-container">
        <div class="page-title-head d-flex align-items-center gap-2 mb-4">
            <div class="flex-grow-1">
                <h4 class="fs-16 text-uppercase fw-bold mb-0">حسابات التواصل الاجتماعي</h4>
                <p class="text-muted mb-0">روابط فيسبوك، انستغرام، تويتر، واتساب، وغيرها</p>
            </div>
            <a href="{{ route('admin.page-contents.index') }}" class="btn btn-outline-secondary">العودة</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.page-contents.social.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        @foreach($keys as $key)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $labels[$key] ?? $key }}</label>
                                <input type="url" name="{{ $key }}" class="form-control" value="{{ old($key, optional($items->get($key))->content) }}" placeholder="https://...">
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy me-1"></i> حفظ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
