@extends('layouts.app')

@section('page_title', 'وصل قبض')
@section('page_subtitle', 'تفاصيل دفعة العميل')

@section('content')

<style>
    .receipt{
        max-width:850px;
        margin:auto;
        background:#fff;
        border-radius:20px;
        box-shadow:0 15px 40px rgba(0,0,0,.06);
        overflow:hidden;
        border:1px solid #e5e7eb;
    }

    .receipt-header{
        background:linear-gradient(135deg,#10b981,#059669);
        color:#fff;
        padding:25px;
    }

    .receipt-header h2{
        margin:0;
        font-weight:900;
    }

    .receipt-body{
        padding:25px;
    }

    .info-grid{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:15px;
        margin-bottom:20px;
    }

    .info-box{
        background:#f9fafb;
        border:1px solid #e5e7eb;
        border-radius:14px;
        padding:14px;
    }

    .info-label{
        font-size:12px;
        color:#6b7280;
        margin-bottom:5px;
    }

    .info-value{
        font-weight:800;
        color:#111827;
    }

    .amount-box{
        text-align:center;
        padding:25px;
        border-radius:18px;
        background:#ecfdf5;
        border:1px solid #bbf7d0;
        margin-bottom:20px;
    }

    .amount-box .title{
        color:#047857;
        font-weight:700;
        margin-bottom:8px;
    }

    .amount-box .value{
        font-size:36px;
        font-weight:900;
        color:#065f46;
    }

    .notes{
        border:1px dashed #e5e7eb;
        padding:15px;
        border-radius:14px;
        background:#fafafa;
    }

    .top-actions{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:15px;
    }

    @media print{
        .no-print{display:none}
        body{background:#fff}
        .receipt{box-shadow:none;border:none}
    }
</style>

<div class="top-actions no-print">

    <div>
        <h4 class="fw-bold mb-1">وصل قبض عميل</h4>
        <small class="text-muted">تفاصيل العملية المالية</small>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('receipts.index') }}" class="btn btn-outline-secondary">
            رجوع
        </a>

        <button onclick="window.print()" class="btn btn-success">
            طباعة
        </button>
    </div>

</div>

<div class="receipt">

    {{-- HEADER --}}
    <div class="receipt-header d-flex justify-content-between align-items-center">

        <div>
            <h2>وصل قبض</h2>
            <div>دفعة من عميل</div>
        </div>

        <div class="text-end">
            <div style="font-size:13px">رقم الوصل</div>
            <div style="font-weight:900;font-size:18px">
                CUS-{{ $payment->id }}
            </div>
        </div>

    </div>

    {{-- BODY --}}
    <div class="receipt-body">

        <div class="info-grid">

            <div class="info-box">
                <div class="info-label">اسم العميل</div>
                <div class="info-value">
                    {{ $payment->customer->name ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="info-label">التاريخ</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}
                </div>
            </div>

            <div class="info-box">
                <div class="info-label">طريقة الدفع</div>
                <div class="info-value">
                    {{ $payment->payment_method ?? 'نقدي' }}
                </div>
            </div>

        </div>

        {{-- AMOUNT --}}
        <div class="amount-box">
            <div class="title">المبلغ المستلم</div>
            <div class="value">
                {{ number_format($payment->amount,2) }}
            </div>
        </div>

        {{-- NOTES --}}
        <div class="notes">
            <strong>ملاحظات:</strong><br>
            {{ $payment->notes ?: 'لا توجد ملاحظات' }}
        </div>

    </div>

</div>

@endsection
