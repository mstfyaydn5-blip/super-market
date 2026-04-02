@extends('layouts.app')

@section('page_title', 'فواتير الشراء')
@section('page_subtitle', 'عرض جميع فواتير الشراء بشكل احترافي')

@section('content')

<style>
    .card-soft{
        border:1px solid #e6e8ef;
        border-radius:18px;
        background:#fff;
        box-shadow:0 10px 25px rgba(0,0,0,.04);
    }

    .stat{
        padding:20px;
        border-radius:18px;
        border:1px solid #eef1f6;
        height:100%;
    }

    .stat-title{
        font-size:13px;
        font-weight:800;
        color:#6b7280;
        margin-bottom:6px;
    }

    .stat-value{
        font-size:26px;
        font-weight:900;
    }

    .bg-total{ background:#eef2ff; color:#4338ca; }
    .bg-paid{ background:#ecfdf5; color:#15803d; }
    .bg-due{ background:#fef2f2; color:#dc2626; }

    .table th{
        background:#f7f8fb !important;
        white-space: nowrap;
    }

    .badge-paid{
        background:#dcfce7;
        color:#15803d;
        padding:5px 10px;
        border-radius:20px;
        font-weight:700;
    }

    .badge-due{
        background:#fee2e2;
        color:#b91c1c;
        padding:5px 10px;
        border-radius:20px;
        font-weight:700;
    }

    .badge-number{
        background:#eef4ff;
        color:#2563eb;
        padding:6px 12px;
        border-radius:999px;
        font-weight:800;
        display:inline-block;
    }
</style>

@php
    $totalPurchases = $invoices->sum('total');
    $totalPaid = $invoices->sum('paid');
    $totalDue = $invoices->sum('remaining');
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold">فواتير الشراء</h3>
        <small class="text-muted">إدارة وعرض فواتير الشراء</small>
    </div>

    <a href="{{ route('purchases.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i>
        إضافة فاتورة شراء
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat bg-total">
            <div class="stat-title">إجمالي الفواتير</div>
            <div class="stat-value">{{ number_format($totalPurchases, 2) }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat bg-paid">
            <div class="stat-title">إجمالي المدفوع</div>
            <div class="stat-value">{{ number_format($totalPaid, 2) }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat bg-due">
            <div class="stat-title">إجمالي المتبقي</div>
            <div class="stat-value">{{ number_format($totalDue, 2) }}</div>
        </div>
    </div>
</div>

<div class="card-soft p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الفاتورة</th>
                    <th>المورد</th>
                    <th>التاريخ</th>
                    <th>الإجمالي</th>
                    <th>المدفوع</th>
                    <th>المتبقي</th>
                    <th>الحالة</th>
                    <th>عرض</th>
                </tr>
            </thead>

            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>

                        <td>
                            <span class="badge-number">
                                {{ $invoice->invoice_number }}
                            </span>
                        </td>

                        <td class="fw-bold">
                            {{ $invoice->supplier->name ?? '-' }}
                        </td>

                        <td>
                            {{ $invoice->invoice_date?->format('Y-m-d') }}
                        </td>

                        <td>{{ number_format($invoice->total, 2) }}</td>
                        <td>{{ number_format($invoice->paid, 2) }}</td>
                        <td>{{ number_format($invoice->remaining, 2) }}</td>

                        <td>
                            @if((float)$invoice->remaining <= 0)
                                <span class="badge-paid">مكتملة</span>
                            @else
                                <span class="badge-due">غير مكتملة</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('purchases.show', $invoice->id) }}" class="btn btn-sm btn-primary">
                                عرض
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-muted py-4">
                            لا توجد فواتير شراء
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $invoices->links() }}
    </div>
</div>

@endsection
