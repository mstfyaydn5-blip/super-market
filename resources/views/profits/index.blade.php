@extends('layouts.app')

@section('page_title', 'الأرباح')
@section('page_subtitle', 'تقارير الأرباح من المبيعات')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">تقارير الأرباح</h3>
            <small class="text-muted">حساب الربح اعتماداً على آخر سعر شراء من المشتريات</small>
        </div>
    </div>

    <form method="GET" action="{{ route('profits.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">من تاريخ</label>
            <input type="date" name="from" class="form-control" value="{{ $from }}">
        </div>

        <div class="col-md-3">
            <label class="form-label">إلى تاريخ</label>
            <input type="date" name="to" class="form-control" value="{{ $to }}">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">فلترة</button>
        </div>
    </form>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="text-muted mb-2">إجمالي المبيعات</div>
                    <h3 class="mb-0">{{ number_format($totalSales, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="text-muted mb-2">إجمالي التكلفة</div>
                    <h3 class="mb-0">{{ number_format($totalCost, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="text-muted mb-2">إجمالي الربح</div>
                    <h3 class="mb-0 text-success">{{ number_format($totalProfit, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>التاريخ</th>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>سعر البيع</th>
                            <th>سعر الشراء</th>
                            <th>الإجمالي</th>
                            <th>الربح</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->sale->invoice_number ?? '-' }}</td>
                                <td>{{ $item->sale->sale_date ?? '-' }}</td>
                                <td>{{ $item->product->name ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ number_format($item->cost_price, 2) }}</td>
                                <td>{{ number_format($item->total, 2) }}</td>
                                <td class="fw-bold {{ $item->profit >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($item->profit, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">لا توجد بيانات أرباح حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
