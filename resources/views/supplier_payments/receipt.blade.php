@extends('layouts.app')

@section('page_title', 'وصل دفعة مورد')
@section('page_subtitle', 'عرض تفاصيل دفعة المورد')

@section('content')

<style>
    .receipt-card{
        max-width: 900px;
        margin: 0 auto;
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:20px;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
        overflow:hidden;
    }

    .receipt-head{
        background:linear-gradient(135deg,#2563eb,#1d4ed8);
        color:#fff;
        padding:24px;
    }

    .receipt-body{
        padding:24px;
    }

    .info-box{
        border:1px solid #e5e7eb;
        border-radius:16px;
        padding:16px;
        background:#f9fafb;
        height:100%;
    }

    .label{
        font-size:13px;
        color:#6b7280;
        margin-bottom:6px;
    }

    .value{
        font-size:16px;
        font-weight:700;
        color:#111827;
    }

    .amount-box{
        border-radius:18px;
        background:#eff6ff;
        color:#1d4ed8;
        padding:20px;
        text-align:center;
        border:1px solid #dbeafe;
    }

    .amount-box .amount{
        font-size:34px;
        font-weight:800;
    }

    @media print{
        .no-print{
            display:none !important;
        }

        body{
            background:#fff !important;
        }

        .receipt-card{
            box-shadow:none;
            border:none;
            max-width:100%;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <h4 class="mb-1 fw-bold">وصل دفعة مورد</h4>
        <small class="text-muted">تفاصيل الدفعة المسجلة</small>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('receipts.index') }}" class="btn btn-outline-secondary rounded-3">
            الرجوع للوصولات
        </a>
        <button onclick="window.print()" class="btn btn-primary rounded-3">
            طباعة
        </button>
    </div>
</div>

<div class="receipt-card">
    <div class="receipt-head">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1">وصل صرف</h3>
                <div>دفعة إلى مورد</div>
            </div>
            <div class="text-end">
                <div class="small">رقم الوصل</div>
                <div class="fw-bold fs-5">SUP-{{ $payment->id }}</div>
            </div>
        </div>
    </div>

    <div class="receipt-body">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="info-box">
                    <div class="label">اسم المورد</div>
                    <div class="value">{{ $payment->supplier->name ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="label">تاريخ الدفعة</div>
                    <div class="value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box">
                    <div class="label">طريقة الدفع</div>
                    <div class="value">{{ $payment->payment_method ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="amount-box mb-4">
            <div class="mb-2">المبلغ المدفوع</div>
            <div class="amount">{{ number_format($payment->amount, 2) }}</div>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <div class="info-box">
                    <div class="label">ملاحظات</div>
                    <div class="value">{{ $payment->notes ?: 'لا توجد ملاحظات' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
