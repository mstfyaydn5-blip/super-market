@extends('layouts.app')

@section('page_title', 'الفواتير')
@section('page_subtitle', 'عرض جميع عمليات البيع بشكل مرتب وواضح')

@section('content')

<style>
    .card-soft{
        border:1px solid #e6e8ef;
        border-radius:18px;
        background:#fff;
        box-shadow:0 10px 25px rgba(0,0,0,.04);
    }

    .stats-card{
        border:1px solid #e8ecf3;
        border-radius:18px;
        padding:18px;
        background:#fff;
        box-shadow:0 8px 18px rgba(0,0,0,.03);
        height:100%;
    }

    .stats-title{
        font-size:13px;
        font-weight:800;
        color:#6b7280;
        margin-bottom:8px;
    }

    .stats-value{
        font-size:28px;
        font-weight:900;
        line-height:1.1;
    }

    .bg-total{
        background:#eef2ff;
        color:#4338ca;
    }

    .bg-count{
        background:#ecfdf5;
        color:#15803d;
    }

    .bg-average{
        background:#fff7ed;
        color:#c2410c;
    }

    .table thead th{
        background:#f7f8fb !important;
        white-space:nowrap;
        vertical-align:middle;
    }

    .table td{
        vertical-align:middle;
    }

    .invoice-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:#eef4ff;
        color:#2563eb;
        padding:6px 12px;
        border-radius:999px;
        font-weight:800;
        min-width:90px;
    }

    .customer-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:#f3f4f6;
        color:#111827;
        padding:6px 12px;
        border-radius:999px;
        font-weight:700;
    }

    .amount-text{
        font-weight:900;
        color:#111827;
    }

    .empty-box{
        text-align:center;
        padding:42px 20px;
        color:#6b7280;
    }

    .empty-icon{
        width:62px;
        height:62px;
        border-radius:18px;
        margin:0 auto 12px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#f3f4f6;
        color:#9ca3af;
        font-size:28px;
    }
</style>

@php
    $pageTotal = $sales->sum('total');
    $pageCount = $sales->count();
    $pageAverage = $pageCount > 0 ? $pageTotal / $pageCount : 0;
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold">الفواتير</h3>
        <small class="text-muted">كل عمليات البيع</small>
    </div>

    @if(Route::has('pos.index'))
        <a href="{{ route('pos.index') }}" class="btn btn-primary rounded-3">
            <i class="bi bi-plus-lg ms-1"></i>
            إنشاء فاتورة
        </a>
    @endif
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stats-card bg-total">
            <div class="stats-title">إجمالي هذه الصفحة</div>
            <div class="stats-value">{{ number_format($pageTotal, 2) }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stats-card bg-count">
            <div class="stats-title">عدد الفواتير</div>
            <div class="stats-value">{{ $pageCount }}</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stats-card bg-average">
            <div class="stats-title">متوسط الفاتورة</div>
            <div class="stats-value">{{ number_format($pageAverage, 2) }}</div>
        </div>
    </div>
</div>

<div class="card-soft p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الفاتورة</th>
                    <th>العميل</th>
                    <th>المبلغ</th>
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>

                        <td>
                            <span class="invoice-badge">
                                #{{ $sale->id }}
                            </span>
                        </td>

                        <td>
                            <span class="customer-badge">
                                {{ $sale->customer->name ?? 'زبون عام' }}
                            </span>
                        </td>

                        <td class="amount-text">
                            {{ number_format($sale->total, 2) }}
                        </td>

                        <td>
                            {{ $sale->created_at->format('Y-m-d') }}
                            <div class="small text-muted mt-1">
                                {{ $sale->created_at->format('H:i') }}
                            </div>
                        </td>

                        <td>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-primary rounded-3">
                                عرض
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-box">
                                <div class="empty-icon">
                                    <i class="bi bi-receipt"></i>
                                </div>
                                <div class="fw-bold mb-1">لا توجد فواتير</div>
                                <div class="small">ستظهر هنا جميع عمليات البيع بعد تسجيلها</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $sales->links() }}
    </div>
</div>

@endsection
