@extends('layouts.app')

@section('page_title', 'دفعة للمورد')
@section('page_subtitle', 'تسجيل دفعة وربطها بفاتورة شراء')

@section('content')

<style>
    .card-soft{
        border:1px solid #e6e8ef;
        border-radius:18px;
        background:#fff;
        box-shadow:0 10px 25px rgba(0,0,0,.04);
    }

    .info-strip{
        border:1px solid #e6e8ef;
        border-radius:16px;
        background:linear-gradient(135deg,#ffffff 0%, #f8fbff 100%);
        padding:18px;
        margin-bottom:18px;
    }

    .info-label{
        font-size:12px;
        color:#6b7280;
        margin-bottom:4px;
        font-weight:700;
    }

    .info-value{
        font-size:16px;
        font-weight:800;
        color:#111827;
    }

    .invoice-box{
        border:1px solid #e8ecf3;
        border-radius:14px;
        padding:12px;
        background:#fafbfc;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0 fw-bold">دفعة للمورد</h3>
        <small class="text-muted">{{ $supplier->name }}</small>
    </div>

    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-secondary rounded-3">
        رجوع
    </a>
</div>

<div class="info-strip">
    <div class="row g-3">
        <div class="col-md-4">
            <div class="info-label">اسم المورد</div>
            <div class="info-value">{{ $supplier->name }}</div>
        </div>

        <div class="col-md-4">
            <div class="info-label">الرصيد الحالي</div>
            <div class="info-value">{{ number_format($supplier->balance ?? $supplier->opening_balance ?? 0, 2) }}</div>
        </div>

        <div class="col-md-4">
            <div class="info-label">عدد الفواتير</div>
            <div class="info-value">{{ isset($purchases) ? $purchases->count() : 0 }}</div>
        </div>
    </div>
</div>

<div class="card-soft p-4">

    <form method="POST" action="{{ route('supplier.payments.store') }}">
        @csrf

        <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">

        <div class="row g-3">

            <div class="col-md-12">
                <label class="form-label fw-bold">اختر الفاتورة</label>
                <select name="purchase_id" class="form-select" required>
                    <option value="">اختر فاتورة الشراء</option>

                    @foreach($purchases as $purchase)
                        <option value="{{ $purchase->id }}">
                            {{ $purchase->invoice_number }}
                            | التاريخ: {{ $purchase->invoice_date?->format('Y-m-d') }}
                            | الإجمالي: {{ number_format($purchase->total, 2) }}
                            | المدفوع: {{ number_format($purchase->paid, 2) }}
                            | المتبقي: {{ number_format($purchase->remaining, 2) }}
                        </option>
                    @endforeach
                </select>

                @if($purchases->isEmpty())
                    <div class="text-danger small mt-2">
                        لا توجد فواتير شراء لهذا المورد لإضافة دفعة عليها.
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">المبلغ</label>
                <input type="number" step="0.01" min="0.01" name="amount" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">تاريخ الدفع</label>
                <input type="date" name="payment_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">طريقة الدفع</label>
                <select name="payment_method" class="form-select">
                    <option value="cash">كاش</option>
                    <option value="bank">تحويل</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">ملاحظات</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="اكتب ملاحظة إن وجدت..."></textarea>
            </div>

            <div class="col-12">
                <button class="btn btn-primary rounded-3" {{ isset($purchases) && $purchases->isEmpty() ? 'disabled' : '' }}>
                    تسجيل الدفعة
                </button>
            </div>

        </div>
    </form>

</div>

@endsection
