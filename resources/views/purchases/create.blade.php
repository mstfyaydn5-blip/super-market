@extends('layouts.app')

@section('page_title', 'إضافة فاتورة شراء')
@section('page_subtitle', 'إدخال فاتورة شراء جديدة وتحديث المخزون بشكل مباشر')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold">فاتورة شراء جديدة</h5>
    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary rounded-3">
        رجوع
    </a>
</div>

<form method="POST" action="{{ route('purchases.store') }}">
    @csrf

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label fw-bold">المورد</label>
            <select name="supplier_id" class="form-select" required>
                <option value="">اختر المورد</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">تاريخ الفاتورة</label>
            <input type="date" name="invoice_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
        </div>

        <div class="col-md-4">
            <label class="form-label fw-bold">الخصم</label>
            <input type="number" step="0.01" min="0" name="discount" id="discount" class="form-control" value="0">
        </div>
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-bordered align-middle text-center" id="itemsTable">
            <thead class="table-light">
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>سعر الشراء</th>
                    <th>المجموع</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="items[0][product_id]" class="form-select product-select" required>
                            <option value="">اختر المنتج</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" step="0.01" min="0.01" name="items[0][quantity]" class="form-control qty" value="1" required></td>
                    <td><input type="number" step="0.01" min="0" name="items[0][purchase_price]" class="form-control price" value="0" required></td>
                    <td><input type="text" class="form-control line-total" value="0.00" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">حذف</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <button type="button" id="addRow" class="btn btn-outline-primary mb-4">
        + إضافة منتج
    </button>

    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label fw-bold">المجموع الفرعي</label>
            <input type="text" id="subtotal" class="form-control" value="0.00" readonly>
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">الإجمالي</label>
            <input type="text" id="total" class="form-control" value="0.00" readonly>
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">المدفوع</label>
            <input type="number" step="0.01" min="0" name="paid" id="paid" class="form-control" value="0">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-bold">المتبقي</label>
            <input type="text" id="remaining" class="form-control" value="0.00" readonly>
        </div>

        <div class="col-12">
            <label class="form-label fw-bold">ملاحظات</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-success rounded-3 px-4">
            حفظ الفاتورة
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let rowIndex = 1;
    const addRowBtn = document.getElementById('addRow');
    const tableBody = document.querySelector('#itemsTable tbody');

    const productOptions = @json($products->map(function($p) {
        return ['id' => $p->id, 'name' => $p->name];
    }));

    function createProductOptions() {
        let options = '<option value="">اختر المنتج</option>';
        productOptions.forEach(product => {
            options += `<option value="${product.id}">${product.name}</option>`;
        });
        return options;
    }

    function recalc() {
        let subtotal = 0;

        document.querySelectorAll('#itemsTable tbody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty')?.value || 0);
            const price = parseFloat(row.querySelector('.price')?.value || 0);
            const lineTotal = qty * price;

            row.querySelector('.line-total').value = lineTotal.toFixed(2);
            subtotal += lineTotal;
        });

        const discount = parseFloat(document.getElementById('discount').value || 0);
        const total = Math.max(subtotal - discount, 0);
        const paid = parseFloat(document.getElementById('paid').value || 0);
        const remaining = Math.max(total - paid, 0);

        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('remaining').value = remaining.toFixed(2);
    }

    addRowBtn.addEventListener('click', function () {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="items[${rowIndex}][product_id]" class="form-select product-select" required>
                    ${createProductOptions()}
                </select>
            </td>
            <td><input type="number" step="0.01" min="0.01" name="items[${rowIndex}][quantity]" class="form-control qty" value="1" required></td>
            <td><input type="number" step="0.01" min="0" name="items[${rowIndex}][purchase_price]" class="form-control price" value="0" required></td>
            <td><input type="text" class="form-control line-total" value="0.00" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">حذف</button></td>
        `;
        tableBody.appendChild(tr);
        rowIndex++;
        recalc();
    });

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty') || e.target.classList.contains('price') || e.target.id === 'discount' || e.target.id === 'paid') {
            recalc();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            const rows = document.querySelectorAll('#itemsTable tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                recalc();
            }
        }
    });

    recalc();
});
</script>
@endpush
