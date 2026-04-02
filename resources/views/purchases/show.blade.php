@extends('layouts.app')

@section('page_title', 'تفاصيل فاتورة الشراء')
@section('page_subtitle', 'عرض كامل لتفاصيل فاتورة الشراء')

@section('content')

<style>
    .invoice-shell{
        max-width: 1100px;
        margin: 0 auto;
    }

    .invoice-card{
        border:1px solid #e6e8ef;
        border-radius:22px;
        background:#fff;
        box-shadow:0 14px 35px rgba(0,0,0,.05);
        overflow:hidden;
    }

    .invoice-head{
        padding:24px;
        background:linear-gradient(135deg,#2563eb,#1d4ed8);
        color:#fff;
    }

    .invoice-title{
        font-size:28px;
        font-weight:900;
        margin:0;
    }

    .invoice-sub{
        opacity:.9;
        margin-top:6px;
        font-size:14px;
    }

    .invoice-number{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:10px 16px;
        border-radius:999px;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.18);
        font-weight:800;
        font-size:14px;
    }

    .invoice-body{
        padding:24px;
    }

    .info-card{
        border:1px solid #edf0f5;
        border-radius:16px;
        background:#fafbfc;
        padding:16px;
        height:100%;
    }

    .info-label{
        font-size:12px;
        color:#6b7280;
        font-weight:700;
        margin-bottom:6px;
    }

    .info-value{
        font-size:16px;
        color:#111827;
        font-weight:800;
    }

    .section-title{
        font-size:22px;
        font-weight:900;
        margin:0 0 16px;
        color:#111827;
    }

    .table thead th{
        background:#f7f8fb !important;
        white-space:nowrap;
        vertical-align:middle;
    }

    .table td{
        vertical-align:middle;
    }

    .summary-card{
        border:1px solid #e8ecf3;
        border-radius:18px;
        padding:18px;
        height:100%;
        box-shadow:0 8px 18px rgba(0,0,0,.03);
    }

    .summary-title{
        font-size:13px;
        font-weight:800;
        margin-bottom:8px;
        color:#6b7280;
    }

    .summary-value{
        font-size:28px;
        font-weight:900;
        line-height:1.1;
    }

    .bg-subtotal{ background:#eef2ff; color:#4338ca; }
    .bg-discount{ background:#fff7ed; color:#c2410c; }
    .bg-total{ background:#ecfdf5; color:#15803d; }
    .bg-paid{ background:#f0fdf4; color:#166534; }
    .bg-remaining{ background:#fef2f2; color:#dc2626; }

    .notes-box{
        border:1px dashed #d7dce5;
        border-radius:16px;
        background:#fafafa;
        padding:18px;
    }

    .actions-bar{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        margin-bottom:16px;
    }

    @media print{
    .no-print,
    .sidebar,
    .top-header,
    .sidebar-footer,
    .sidebar-search-wrap,
    .settings-panel,
    .settings-backdrop{
        display:none !important;
    }

    html, body{
        background:#fff !important;
        overflow:visible !important;
        height:auto !important;
    }

    body *{
        visibility:hidden;
    }

    .invoice-shell,
    .invoice-shell *{
        visibility:visible;
    }

    .invoice-shell{
        max-width:100% !important;
        width:100% !important;
        margin:0 !important;
        padding:0 !important;
    }

    .main-wrap{
        width:100% !important;
        height:auto !important;
        overflow:visible !important;
        padding:0 !important;
        margin:0 !important;
    }

    .content-area{
        display:block !important;
        margin:0 !important;
        padding:0 !important;
    }

    .content-card{
        box-shadow:none !important;
        border:none !important;
        padding:0 !important;
        margin:0 !important;
        background:#fff !important;
    }

    .invoice-card{
        box-shadow:none !important;
        border:none !important;
        border-radius:0 !important;
        width:100% !important;
    }

    .invoice-head{
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .summary-card{
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        box-shadow:none !important;
    }

    table{
        width:100% !important;
        border-collapse:collapse !important;
    }

    th, td{
        page-break-inside:avoid !important;
    }

    @page{
        size:A4;
        margin:12mm;
    }
}
    }
</style>

<div class="invoice-shell">

    <div class="actions-bar no-print">
        <div>
            <h4 class="fw-bold mb-1">فاتورة شراء</h4>
            <small class="text-muted">تفاصيل كاملة للطباعة والمراجعة</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary rounded-3">
                رجوع
            </a>

            <button type="button" onclick="window.print()" class="btn btn-primary rounded-3">
                <i class="bi bi-printer ms-1"></i>
                طباعة
            </button>
        </div>
    </div>

    <div class="invoice-card">

        <div class="invoice-head">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h1 class="invoice-title">فاتورة شراء</h1>
                    <div class="invoice-sub">عرض تفاصيل الفاتورة والمبالغ والمواد المسجلة</div>
                </div>

                <div class="invoice-number">
                    رقم الفاتورة: {{ $purchase->invoice_number }}
                </div>
            </div>
        </div>

        <div class="invoice-body">

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-label">اسم المورد</div>
                        <div class="info-value">{{ $purchase->supplier->name ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-label">تاريخ الفاتورة</div>
                        <div class="info-value">{{ $purchase->invoice_date?->format('Y-m-d') }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-card">
                        <div class="info-label">المستخدم</div>
                        <div class="info-value">{{ $purchase->user->name ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <h3 class="section-title">مواد الفاتورة</h3>

            <div class="table-responsive mb-4">
                <table class="table table-hover table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>سعر الشراء</th>
                            <th>المجموع</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchase->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $item->product->name ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->purchase_price, 2) }}</td>
                                <td class="fw-bold">{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted py-4">لا توجد مواد داخل الفاتورة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-lg col-md-6">
                    <div class="summary-card bg-subtotal">
                        <div class="summary-title">المجموع الفرعي</div>
                        <div class="summary-value">{{ number_format($purchase->subtotal, 2) }}</div>
                    </div>
                </div>

                <div class="col-lg col-md-6">
                    <div class="summary-card bg-discount">
                        <div class="summary-title">الخصم</div>
                        <div class="summary-value">{{ number_format($purchase->discount, 2) }}</div>
                    </div>
                </div>

                <div class="col-lg col-md-6">
                    <div class="summary-card bg-total">
                        <div class="summary-title">الإجمالي</div>
                        <div class="summary-value">{{ number_format($purchase->total, 2) }}</div>
                    </div>
                </div>

                <div class="col-lg col-md-6">
                    <div class="summary-card bg-paid">
                        <div class="summary-title">المدفوع</div>
                        <div class="summary-value">{{ number_format($purchase->paid, 2) }}</div>
                    </div>
                </div>

                <div class="col-lg col-md-6">
                    <div class="summary-card bg-remaining">
                        <div class="summary-title">المتبقي</div>
                        <div class="summary-value">{{ number_format($purchase->remaining, 2) }}</div>
                    </div>
                </div>
            </div>

            @if($purchase->notes)
                <div>
                    <h3 class="section-title">ملاحظات</h3>
                    <div class="notes-box">
                        {{ $purchase->notes }}
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>

@endsection
