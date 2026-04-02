@extends('layouts.app')

@section('page_title', 'العملاء')
@section('page_subtitle', 'إدارة العملاء وعرض الأرصدة وكشوف الحسابات')

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
        <h3 class="mb-0">العملاء</h3>
        <small class="text-muted">إدارة العملاء</small>
    </div>

    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-soft">
        <i class="bi bi-plus-lg"></i>
        إضافة عميل
    </a>
</div>

<div class="card-soft p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>الهاتف</th>
                    <th>الرصيد الحالي</th>
                    <th width="330">الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>

                        <td class="fw-bold">{{ $customer->name }}</td>

                        <td>{{ $customer->phone ?: '-' }}</td>

                        <td>
                            <span class="badge-balance">
                                {{ number_format($customer->balance ?? $customer->opening_balance ?? 0, 2) }}
                            </span>
                        </td>

                        <td>
                            <div class="actions-wrap justify-content-center">
                                <a href="{{ route('customers.show', $customer->id) }}"
                                   class="btn btn-info btn-sm btn-soft">
                                    عرض
                                </a>

                                @if(Route::has('customers.statement'))
                                    <a href="{{ route('customers.statement', $customer->id) }}"
                                       class="btn btn-dark btn-sm btn-soft">
                                        كشف الحساب
                                    </a>
                                @endif

                                @if(Route::has('customer.payments.create'))
                                    <a href="{{ route('customer.payments.create', $customer->id) }}"
                                       class="btn btn-success btn-sm btn-soft">
                                        إضافة دفعة
                                    </a>
                                @endif

                                <a href="{{ route('customers.edit', $customer->id) }}"
                                   class="btn btn-warning btn-sm btn-soft">
                                    تعديل
                                </a>

                                <form action="{{ route('customers.destroy', $customer->id) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm btn-soft">
                                        حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            لا يوجد عملاء
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $customers->links() }}
    </div>
</div>

@endsection
