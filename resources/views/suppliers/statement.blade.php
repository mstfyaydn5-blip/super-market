@extends('layouts.app')

@section('page_title', 'كشف حساب المورد')
@section('page_subtitle', 'عرض جميع فواتير الشراء والدفعات مع الرصيد التراكمي')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h4 class="mb-1 fw-bold">{{ $supplier->name }}</h4>
        <div class="text-muted">
            كشف حساب المورد
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary rounded-3">
            رجوع
        </a>

        <button type="button" class="btn btn-primary rounded-3" onclick="window.print()">
            طباعة
        </button>
    </div>
</div>

<form method="GET" action="{{ route('suppliers.statement', $supplier->id) }}" class="mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold">من تاريخ</label>
            <input type="date" name="from" value="{{ $from }}" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">إلى تاريخ</label>
            <input type="date" name="to" value="{{ $to }}" class="form-control">
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-dark rounded-3 w-100">
                فلترة
            </button>

            <a href="{{ route('suppliers.statement', $supplier->id) }}" class="btn btn-outline-secondary rounded-3 w-100">
                تصفير
            </a>
        </div>
    </div>
</form>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="background:#eef2ff;">
            <div class="card-body text-center">
                <div class="fw-bold text-primary mb-2">الرصيد الافتتاحي</div>
                <div class="fs-4 fw-bold text-primary">
                    {{ number_format($supplier->opening_balance ?? 0, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="background:#ecfdf5;">
            <div class="card-body text-center">
                <div class="fw-bold text-success mb-2">إجمالي الفواتير</div>
                <div class="fs-4 fw-bold text-success">
                    {{ number_format($totalDebit, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="background:#fff7ed;">
            <div class="card-body text-center">
                <div class="fw-bold text-warning mb-2">إجمالي الدفعات</div>
                <div class="fs-4 fw-bold text-warning">
                    {{ number_format($totalCredit, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="background:#fef2f2;">
            <div class="card-body text-center">
                <div class="fw-bold text-danger mb-2">الرصيد الحالي</div>
                <div class="fs-4 fw-bold text-danger">
                    {{ number_format($currentBalance, 2) }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold">كشف الحساب</h5>
            <span class="text-muted small">عدد الحركات: {{ $rows->count() }}</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle text-center table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>نوع الحركة</th>
                        <th>المرجع</th>
                        <th>التفاصيل</th>
                        <th>مدين</th>
                        <th>دائن</th>
                        <th>الرصيد التراكمي</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $opening = (float)($supplier->opening_balance ?? 0);
                    @endphp

                    <tr style="background:#f8fafc;">
                        <td>-</td>
                        <td>-</td>
                        <td><span class="badge bg-secondary">افتتاحي</span></td>
                        <td>-</td>
                        <td>الرصيد الافتتاحي</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="fw-bold">{{ number_format($opening, 2) }}</td>
                    </tr>

                    @forelse($rows as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($row['date'])->format('Y-m-d') }}</td>
                            <td>
                                @if($row['type'] === 'فاتورة شراء')
                                    <span class="badge bg-primary">{{ $row['type'] }}</span>
                                @else
                                    <span class="badge bg-success">{{ $row['type'] }}</span>
                                @endif
                            </td>
                            <td>{{ $row['reference'] }}</td>
                            <td>{{ $row['details'] }}</td>
                            <td class="text-danger fw-bold">
                                {{ $row['debit'] > 0 ? number_format($row['debit'], 2) : '-' }}
                            </td>
                            <td class="text-success fw-bold">
                                {{ $row['credit'] > 0 ? number_format($row['credit'], 2) : '-' }}
                            </td>
                            <td class="fw-bold">{{ number_format($row['running_balance'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted py-4">
                                لا توجد حركات ضمن هذه الفترة
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if($rows->count())
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="5">الإجماليات</th>
                            <th class="text-danger">{{ number_format($totalDebit, 2) }}</th>
                            <th class="text-success">{{ number_format($totalCredit, 2) }}</th>
                            <th>{{ number_format($currentBalance, 2) }}</th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
