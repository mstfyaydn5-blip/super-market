@extends('layouts.app')

@section('page_title', 'الوصولات')
@section('page_subtitle', 'عرض جميع وصولات الموردين والعملاء')

@section('content')

<style>
    .card-soft{
        border:1px solid #e6e8ef;
        border-radius:16px;
        background:#fff;
        box-shadow:0 10px 25px rgba(0,0,0,.04);
    }

    .btn-soft{
        border-radius:10px;
        font-weight:700;
    }

    .table th{
        background:#f7f8fb !important;
        white-space: nowrap;
    }

    .badge-supplier{
        background:#fee2e2;
        color:#b91c1c;
        padding:6px 12px;
        border-radius:20px;
        font-weight:700;
    }

    .badge-customer{
        background:#dcfce7;
        color:#15803d;
        padding:6px 12px;
        border-radius:20px;
        font-weight:700;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">الوصولات</h3>
        <small class="text-muted">دفعات الموردين والعملاء</small>
    </div>
</div>

<div class="card-soft p-3 mb-3">
    <form method="GET" action="{{ route('receipts.index') }}">
        <div class="row g-2">
            <div class="col-md-4">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="بحث باسم الطرف أو المرجع..."
                >
            </div>

            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">كل الأنواع</option>
                    <option value="دفعة مورد" {{ request('type') == 'دفعة مورد' ? 'selected' : '' }}>دفعة مورد</option>
                    <option value="دفعة عميل" {{ request('type') == 'دفعة عميل' ? 'selected' : '' }}>دفعة عميل</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-dark w-100 btn-soft">بحث</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('receipts.index') }}" class="btn btn-outline-secondary w-100 btn-soft">تصفير</a>
            </div>
        </div>
    </form>
</div>

<div class="card-soft p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>النوع</th>
                    <th>الطرف</th>
                    <th>المرجع</th>
                    <th>التاريخ</th>
                    <th>المبلغ</th>
                    <th>الوصل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receipts as $index => $receipt)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            @if($receipt['type'] === 'دفعة مورد')
                                <span class="badge-supplier">{{ $receipt['type'] }}</span>
                            @else
                                <span class="badge-customer">{{ $receipt['type'] }}</span>
                            @endif
                        </td>

                        <td class="fw-bold">{{ $receipt['party'] }}</td>
                        <td>{{ $receipt['reference'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($receipt['date'])->format('Y-m-d') }}</td>
                        <td class="fw-bold">{{ number_format($receipt['amount'], 2) }}</td>

                        <td>
                            <a href="{{ $receipt['route'] }}" class="btn btn-primary btn-sm btn-soft">
                                عرض الوصل
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted py-4">لا توجد وصولات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
