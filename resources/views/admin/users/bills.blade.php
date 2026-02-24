@extends('admin.layouts.main')
@section('title', 'فواتير المستخدم')
@section('content')
    <div class="page-content">
        <div class="page-container">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-16 text-uppercase fw-bold mb-0">فواتير المستخدم: {{ $user->name }}</h4>
                    <p class="text-muted mb-0">عرض جميع الفواتير والعمليات المالية للمستخدم</p>
                </div>
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">المستخدمون</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user->id) }}">تفاصيل المستخدم</a>
                        </li>
                        <li class="breadcrumb-item active">الفواتير</li>
                    </ol>
                </div>
            </div>

            <!-- معلومات المستخدم -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                @if ($user->profile_image)
                                    <img src="{{ $user->profile_image }}" alt="User" class="rounded-circle me-3"
                                        width="60" height="60">
                                @else
                                    <span class="avatar-title bg-light rounded-circle me-3"
                                        style="width: 60px; height: 60px; line-height: 60px;">
                                        <i class="ti ti-user"></i>
                                    </span>
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <p class="text-muted mb-0">{{ $user->phone }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="d-flex align-items-center justify-content-end gap-3">
                                <div>
                                    <span class="text-muted d-block">رصيد المحفظة</span>
                                    <h4 class="mb-0 text-success fw-bold">
                                        {{ number_format($stats['current_wallet_balance'] ?? 0, 2) }} ر.س
                                    </h4>
                                </div>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary">
                                    <i class="ti ti-arrow-right"></i> العودة للمستخدم
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.users.bills', $user->id) }}" class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">نوع الفاتورة</label>
                            <select name="type" class="form-select">
                                <option value="">جميع الأنواع</option>
                                <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>إيداع
                                </option>
                                <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>سحب
                                </option>
                                <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>دفع</option>
                                <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>استرداد
                                </option>
                                <option value="commission" {{ request('type') === 'commission' ? 'selected' : '' }}>عمولة
                                </option>
                                <option value="bonus" {{ request('type') === 'bonus' ? 'selected' : '' }}>مكافأة</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">المبلغ من</label>
                            <input type="number" name="min_amount" class="form-control"
                                value="{{ request('min_amount') }}" placeholder="من" step="0.01">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">المبلغ إلى</label>
                            <input type="number" name="max_amount" class="form-control"
                                value="{{ request('max_amount') }}" placeholder="إلى" step="0.01">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">ترتيب حسب</label>
                            <select name="sort" class="form-select">
                                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>تاريخ
                                    الإنشاء</option>
                                <option value="amount" {{ request('sort') === 'amount' ? 'selected' : '' }}>المبلغ</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-search"></i> بحث
                                </button>
                                <a href="{{ route('admin.users.bills', $user->id) }}" class="btn btn-secondary">
                                    <i class="ti ti-refresh"></i> إعادة تعيين
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1 mb-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي الفواتير</h5>
                            <div class="d-flex align-items-center gap-2 my-2 py-1">
                                <span class="avatar-title bg-primary-subtle rounded-circle"><i
                                        class="ti ti-receipt"></i></span>
                                <h3 class="mb-0 fw-bold">{{ number_format($stats['total_bills'] ?? 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي الإيداعات</h5>
                            <div class="d-flex align-items-center gap-2 my-2 py-1">
                                <span class="avatar-title bg-success-subtle rounded-circle"><i
                                        class="ti ti-plus"></i></span>
                                <h3 class="mb-0 fw-bold text-success">
                                    {{ number_format($stats['total_deposits'] ?? 0, 2) }} ر.س</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي المدفوعات</h5>
                            <div class="d-flex align-items-center gap-2 my-2 py-1">
                                <span class="avatar-title bg-danger-subtle rounded-circle"><i
                                        class="ti ti-credit-card"></i></span>
                                <h3 class="mb-0 fw-bold text-danger">
                                    {{ number_format($stats['total_payments'] ?? 0, 2) }} ر.س</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="header-title">إجمالي الاستردادات</h5>
                            <div class="d-flex align-items-center gap-2 my-2 py-1">
                                <span class="avatar-title bg-info-subtle rounded-circle"><i
                                        class="ti ti-rotate-clockwise"></i></span>
                                <h3 class="mb-0 fw-bold text-info">
                                    {{ number_format($stats['total_refunds'] ?? 0, 2) }} ر.س</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bills Table -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="header-title mb-0">قائمة الفواتير</h5>
                    <div>
                        <span class="text-muted">إجمالي النتائج: {{ $bills->total() }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($bills->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-custom table-centered table-sm table-nowrap table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>الطلب</th>
                                        <th>النوع</th>
                                        <th>المبلغ</th>
                                        <th>الملاحظات</th>
                                        <th>تاريخ الإنشاء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bills as $bill)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">#{{ $bill->id }}</span>
                                            </td>
                                            <td>
                                                @if ($bill->order)
                                                    <div>
                                                        <a href="{{ route('admin.orders.show', $bill->order->id) }}"
                                                            class="fw-bold text-primary">
                                                            #{{ $bill->order->order_number }}
                                                        </a>
                                                        <br><small
                                                            class="text-muted">{{ $bill->order->service->name_ar ?? 'غير محدد' }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($bill->type === 'deposit')
                                                    <span class="badge bg-success-subtle text-success"><i
                                                            class="ti ti-plus"></i> إيداع</span>
                                                @elseif($bill->type === 'withdrawal')
                                                    <span class="badge bg-warning-subtle text-warning"><i
                                                            class="ti ti-minus"></i> سحب</span>
                                                @elseif($bill->type === 'payment')
                                                    <span class="badge bg-danger-subtle text-danger"><i
                                                            class="ti ti-credit-card"></i> دفع</span>
                                                @elseif($bill->type === 'refund')
                                                    <span class="badge bg-info-subtle text-info"><i
                                                            class="ti ti-rotate-clockwise"></i> استرداد</span>
                                                @elseif($bill->type === 'commission')
                                                    <span class="badge bg-secondary-subtle text-secondary"><i
                                                            class="ti ti-percentage"></i> عمولة</span>
                                                @elseif($bill->type === 'bonus')
                                                    <span class="badge bg-primary-subtle text-primary"><i
                                                            class="ti ti-gift"></i> مكافأة</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary">{{ $bill->type }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <span
                                                        class="fw-bold text-{{ in_array($bill->type, ['deposit', 'refund', 'commission', 'bonus']) ? 'success' : 'danger' }}">
                                                        {{ in_array($bill->type, ['deposit', 'refund', 'commission', 'bonus']) ? '+' : '-' }}{{ number_format($bill->amount, 2) }}
                                                        ر.س
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $bill->notes ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="fw-bold">{{ $bill->created_at->format('Y-m-d') }}</span>
                                                    <br><small
                                                        class="text-muted">{{ $bill->created_at->format('H:i') }}</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer">
                            {{ $bills->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <span class="avatar-title bg-light rounded-circle"><i
                                    class="ti ti-receipt text-muted fs-32"></i></span>
                            <h4 class="fw-semibold mb-2">لا توجد فواتير</h4>
                            <p class="text-muted">لم يتم العثور على فواتير تطابق معايير البحث.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
