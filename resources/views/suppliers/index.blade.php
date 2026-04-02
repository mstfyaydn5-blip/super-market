@extends('layouts.app')

@section('page_title', 'الموردين')
@section('page_subtitle', 'إدارة الموردين وعرض الأرصدة وكشوف الحسابات')

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

    .badge-balance{
        background:#eef4ff;
        color:#2563eb;
        padding:6px 12px;
        border-radius:20px;
        font-weight:700;
        display:inline-block;
        min-width:100px;
        text-align:center;
    }

    .actions-wrap{
        display:flex;
        flex-wrap:wrap;
        gap:6px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">الموردين</h3>
        <small class="text-muted">إدارة الموردين</small>
    </div>

    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-soft">
        <i class="bi bi-plus-lg"></i>
        إضافة مورد
    </a>
</div>

<div class="card-soft p-3 mb-3">
    <form method="GET" action="{{ route('suppliers.index') }}">
        <div class="row g-2">
            <div class="col-md-4">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="بحث عن مورد..."
                >
            </div>

            <div class="col-md-2">
                <button class="btn btn-dark w-100 btn-soft">بحث</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary w-100 btn-soft">
                    تصفير
                </a>
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
                    <th>اسم المورد</th>
                    <th>الهاتف</th>
                    <th>البريد</th>
                    <th>الرصيد الحالي</th>
                    <th width="330">الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>

                        <td class="fw-bold">{{ $supplier->name }}</td>

                        <td>{{ $supplier->phone ?: '-' }}</td>

                        <td>{{ $supplier->email ?: '-' }}</td>

                        <td>
                            <span class="badge-balance">
                                {{ number_format($supplier->balance ?? $supplier->opening_balance ?? 0, 2) }}
                            </span>
                        </td>

                        <td>
                            <div class="actions-wrap justify-content-center">
                                <a href="{{ route('suppliers.show', $supplier->id) }}"
                                   class="btn btn-sm btn-info btn-soft">
                                    عرض
                                </a>

                                <a href="{{ route('suppliers.statement', $supplier->id) }}"
                                   class="btn btn-sm btn-dark btn-soft">
                                    كشف الحساب
                                </a>

                                <a href="{{ route('supplier.payments.create', $supplier->id) }}"
                                   class="btn btn-sm btn-success btn-soft">
                                    إضافة دفعة
                                </a>

                                <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                   class="btn btn-sm btn-warning btn-soft">
                                    تعديل
                                </a>

                                <form
                                    action="{{ route('suppliers.destroy', $supplier->id) }}"
                                    method="POST"
                                    style="display:inline-block"
                                    onsubmit="return confirm('هل أنت متأكد من الحذف؟')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger btn-soft">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            لا يوجد موردين
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $suppliers->withQueryString()->links() }}
    </div>
</div>

@endsection
