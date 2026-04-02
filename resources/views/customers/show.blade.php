@extends('layouts.app')

@section('page_title', 'تفاصيل العميل')
@section('page_subtitle', 'عرض بيانات العميل وكشف حسابه بشكل مرتب')

@section('content')

<style>
    .customer-hero{
        border:1px solid #e6e8ef;
        border-radius:22px;
        background:linear-gradient(135deg,#ffffff 0%, #f8fbff 100%);
        box-shadow:0 14px 35px rgba(0,0,0,.05);
        padding:24px;
        margin-bottom:22px;
    }

    .customer-avatar{
        width:72px;
        height:72px;
        border-radius:22px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg,#2563eb,#1d4ed8);
        color:#fff;
        font-size:28px;
        font-weight:900;
        box-shadow:0 14px 25px rgba(37,99,235,.22);
    }

    .soft-card{
        border:1px solid #e6e8ef;
        border-radius:18px;
        background:#fff;
        box-shadow:0 10px 25px rgba(0,0,0,.04);
    }

    .stat-card{
        border-radius:18px;
        padding:20px;
        height:100%;
        border:1px solid #e8ecf3;
        box-shadow:0 8px 18px rgba(0,0,0,.03);
    }

    .stat-title{
        font-size:14px;
        font-weight:800;
        margin-bottom:8px;
    }

    .stat-value{
        font-size:30px;
        font-weight:900;
        line-height:1.1;
    }

    .stat-sub{
        margin-top:8px;
        color:#6b7280;
        font-size:12px;
        font-weight:600;
    }

    .bg-open{ background:#eef2ff; }
    .bg-payments{ background:#ecfdf5; }
    .bg-sales{ background:#fff7ed; }
    .bg-balance{ background:#fef2f2; }

    .text-open{ color:#4338ca; }
    .text-payments{ color:#15803d; }
    .text-sales{ color:#c2410c; }
    .text-balance{ color:#dc2626; }

    .info-item{
        padding:14px 16px;
        border:1px solid #edf0f5;
        border-radius:14px;
        background:#fafbfc;
        height:100%;
    }

    .info-label{
        font-size:12px;
        color:#6b7280;
        margin-bottom:6px;
        font-weight:700;
    }

    .info-value{
        font-size:15px;
        color:#111827;
        font-weight:800;
        word-break:break-word;
    }

    .section-head{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        margin-bottom:16px;
    }

    .section-title{
        font-size:22px;
        font-weight:900;
        margin:0;
        color:#111827;
    }

    .table thead th{
        background:#f7f8fb !important;
        white-space:nowrap;
    }

    .badge-method{
        padding:7px 12px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
        background:#eef4ff;
        color:#2563eb;
    }

    .empty-box{
        text-align:center;
        padding:40px 20px;
        color:#6b7280;
    }

    .empty-icon{
        width:60px;
        height:60px;
        border-radius:18px;
        margin:0 auto 12px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#f3f4f6;
        color:#9ca3af;
        font-size:26px;
    }
</style>

<div class="customer-hero">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="customer-avatar">
                {{ strtoupper(mb_substr($customer->name ?? 'C', 0, 1)) }}
            </div>

            <div>
                <h2 class="mb-1 fw-bold">{{ $customer->name }}</h2>
                <div class="text-muted">ملف العميل وكشف حسابه</div>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary rounded-3">
                رجوع
            </a>

            <a href="{{ route('customer.payments.create', $customer->id) }}" class="btn btn-success rounded-3">
                <i class="bi bi-plus-circle ms-1"></i>
                إضافة دفعة
            </a>

            @if(Route::has('customers.statement'))
                <a href="{{ route('customers.statement', $customer->id) }}" class="btn btn-dark rounded-3">
                    <i class="bi bi-receipt ms-1"></i>
                    كشف الحساب الكامل
                </a>
            @endif
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card bg-open">
            <div class="stat-title text-open">الرصيد الافتتاحي</div>
            <div class="stat-value text-open">{{ number_format($customer->opening_balance ?? 0, 2) }}</div>
            <div class="stat-sub">الرصيد المبدئي المسجل عند إنشاء العميل</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card bg-sales">
            <div class="stat-title text-sales">إجمالي الفواتير</div>
            <div class="stat-value text-sales">{{ number_format($totalSales ?? 0, 2) }}</div>
            <div class="stat-sub">مجموع فواتير البيع الخاصة بالعميل</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card bg-payments">
            <div class="stat-title text-payments">إجمالي الدفعات</div>
            <div class="stat-value text-payments">{{ number_format($totalPayments ?? 0, 2) }}</div>
            <div class="stat-sub">كل المبالغ التي دفعها العميل</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card bg-balance">
            <div class="stat-title text-balance">الرصيد الحالي</div>
            <div class="stat-value text-balance">{{ number_format($currentBalance ?? 0, 2) }}</div>
            <div class="stat-sub">الرصيد النهائي بعد الفواتير والدفعات</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="info-item">
            <div class="info-label">اسم العميل</div>
            <div class="info-value">{{ $customer->name ?? '-' }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-item">
            <div class="info-label">رقم الهاتف</div>
            <div class="info-value">{{ $customer->phone ?: '-' }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="info-item">
            <div class="info-label">البريد الإلكتروني</div>
            <div class="info-value">{{ $customer->email ?: '-' }}</div>
        </div>
    </div>

    @if(isset($customer->address))
        <div class="col-md-6">
            <div class="info-item">
                <div class="info-label">العنوان</div>
                <div class="info-value">{{ $customer->address ?: '-' }}</div>
            </div>
        </div>
    @endif

    @if(isset($customer->notes))
        <div class="col-md-6">
            <div class="info-item">
                <div class="info-label">ملاحظات</div>
                <div class="info-value">{{ $customer->notes ?: '-' }}</div>
            </div>
        </div>
    @endif
</div>

<div class="soft-card p-4">
    <div class="section-head">
        <div>
            <h3 class="section-title">آخر الدفعات</h3>
            <div class="text-muted small">جميع الدفعات المسجلة لهذا العميل</div>
        </div>

        <a href="{{ route('customer.payments.create', $customer->id) }}" class="btn btn-success rounded-3">
            إضافة دفعة
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>المبلغ</th>
                    <th>طريقة الدفع</th>
                    <th>ملاحظات</th>
                    <th>الوصل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
                        <td class="fw-bold">{{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="badge-method">
                                {{ $payment->payment_method ?: 'نقدي' }}
                            </span>
                        </td>
                        <td>{{ $payment->notes ?: '-' }}</td>
                        <td>
                            @if(Route::has('customer.payments.receipt'))
                                <a href="{{ route('customer.payments.receipt', $payment->id) }}"
                                   class="btn btn-sm btn-outline-primary rounded-3">
                                    عرض الوصل
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-box">
                                <div class="empty-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="fw-bold mb-1">لا توجد دفعات حالياً</div>
                                <div class="small">ابدأ بإضافة أول دفعة لهذا العميل</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
