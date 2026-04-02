@extends('layouts.app')

@section('content')

<style>
.pos-box{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.05);
    border:1px solid #e6e8ef;
}
.product-card{
    border:1px solid #e6e8ef;
    border-radius:14px;
    padding:14px;
    cursor:pointer;
    transition:.15s;
    background:#fff;
    height:100%;
}
.product-card:hover{
    background:#f7f8fb;
    transform:translateY(-2px);
}
.product-name{
    font-weight:800;
    margin-bottom:6px;
}
.product-price{
    color:#2563eb;
    font-weight:800;
    font-size:18px;
}
.product-qty{
    font-size:12px;
    color:#6b7280;
}
.cart-table td, .cart-table th{
    vertical-align:middle;
    text-align:center;
}
.remove-btn{
    border:none;
    background:#fee2e2;
    color:#b91c1c;
    width:32px;
    height:32px;
    border-radius:8px;
    font-weight:bold;
}
.search-box{
    border:1px solid #e6e8ef;
    border-radius:12px;
    padding:10px 14px;
}
.total-box{
    background:#f8fafc;
    border:1px solid #e6e8ef;
    border-radius:14px;
    padding:14px;
}
.summary-line{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
    font-size:15px;
}
.summary-line:last-child{
    margin-bottom:0;
}
.summary-value{
    font-weight:800;
}
.remain-positive{
    color:#dc2626;
}
.remain-zero{
    color:#16a34a;
}
.qty-input{
    width:80px;
    text-align:center;
    border:1px solid #dbe1ea;
    border-radius:10px;
    padding:6px 8px;
}
.empty-cart{
    text-align:center;
    color:#6b7280;
    padding:18px 8px;
    font-size:14px;
}
.sticky-side{
    position:sticky;
    top:90px;
}
@media (max-width: 991px){
    .sticky-side{
        position:static;
    }
}
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">الكاشير</h3>
            <small class="text-muted">نظام البيع المباشر</small>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger rounded-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pos.store') }}" onsubmit="return prepareCart()">
        @csrf

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="pos-box">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="mb-0">المنتجات</h5>
                        <input type="text" id="productSearch" class="search-box" placeholder="ابحث عن منتج...">
                    </div>

                    <div class="row g-2">
                        @foreach($products as $product)
                            <div class="col-md-4 col-xl-3 product-item" data-name="{{ strtolower($product->name) }}">
                                <div class="product-card" onclick="addProduct('{{ $product->id }}','{{ $product->name }}','{{ $product->price }}','{{ $product->quantity }}')">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-price">{{ number_format($product->price, 2) }}</div>
                                    <div class="product-qty">المتوفر: {{ $product->quantity }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="pos-box sticky-side">
                    <h5 class="mb-3">الفاتورة</h5>

                    <div class="mb-3">
                        <label class="form-label">العميل</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">اختر العميل</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">طريقة الدفع</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="cash">نقدي</option>
                            <option value="credit">آجل</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">المدفوع</label>
                        <input type="number" step="0.01" min="0" id="paid_amount_display" class="form-control" value="0">
                        <input type="hidden" name="paid_amount" id="paid_amount" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="ملاحظات على الفاتورة..."></textarea>
                    </div>

                    <div class="table-responsive">
                        <table class="table cart-table" id="cartTable">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>المجموع</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="empty-cart">السلة فارغة</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="total-box mt-3">
                        <div class="summary-line">
                            <span>المجموع</span>
                            <span class="summary-value" id="total">0.00</span>
                        </div>

                        <div class="summary-line">
                            <span>المدفوع</span>
                            <span class="summary-value text-success" id="paidPreview">0.00</span>
                        </div>

                        <div class="summary-line">
                            <span>المتبقي</span>
                            <span class="summary-value remain-zero" id="remaining">0.00</span>
                        </div>
                    </div>

                    <input type="hidden" name="sale_date" value="{{ now()->toDateString() }}">
                    <input type="hidden" name="discount" value="0">

                    <div id="hiddenInputs"></div>

                    <button type="submit" class="btn btn-success w-100 mt-3">
                        إتمام البيع
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let cart = [];

function addProduct(id, name, price, stock) {
    const existing = cart.find(item => item.id == id);

    if (existing) {
        if (existing.qty < parseInt(stock)) {
            existing.qty += 1;
        }
    } else {
        cart.push({
            id: id,
            name: name,
            price: parseFloat(price),
            stock: parseInt(stock),
            qty: 1
        });
    }

    renderCart();
}

function removeItem(index) {
    cart.splice(index, 1);
    renderCart();
}

function updateQty(index, value) {
    let qty = parseInt(value);

    if (isNaN(qty) || qty < 1) {
        qty = 1;
    }

    if (qty > cart[index].stock) {
        qty = cart[index].stock;
    }

    cart[index].qty = qty;
    renderCart();
}

function calculateTotal() {
    let total = 0;
    cart.forEach(item => {
        total += item.price * item.qty;
    });
    return total;
}

function updatePaymentSummary() {
    const total = calculateTotal();
    const paidDisplay = document.getElementById("paid_amount_display");
    const paidHidden = document.getElementById("paid_amount");

    let paid = parseFloat(paidDisplay.value);

    if (isNaN(paid) || paid < 0) {
        paid = 0;
        paidDisplay.value = 0;
    }

    if (paid > total) {
        paid = total;
        paidDisplay.value = total.toFixed(2);
    }

    paidHidden.value = paid;

    const remaining = Math.max(total - paid, 0);

    document.getElementById("total").innerText = total.toFixed(2);
    document.getElementById("paidPreview").innerText = paid.toFixed(2);

    const remainingEl = document.getElementById("remaining");
    remainingEl.innerText = remaining.toFixed(2);

    if (remaining > 0) {
        remainingEl.classList.remove("remain-zero");
        remainingEl.classList.add("remain-positive");
    } else {
        remainingEl.classList.remove("remain-positive");
        remainingEl.classList.add("remain-zero");
    }
}

function renderCart() {
    let tbody = document.querySelector("#cartTable tbody");
    tbody.innerHTML = "";

    if (cart.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="empty-cart">السلة فارغة</td>
            </tr>
        `;
        document.getElementById("paid_amount_display").value = 0;
        document.getElementById("paid_amount").value = 0;
        updatePaymentSummary();
        return;
    }

    cart.forEach((item, index) => {
        const lineTotal = item.price * item.qty;

        tbody.innerHTML += `
            <tr>
                <td class="fw-bold">${item.name}</td>
                <td>
                    <input
                        type="number"
                        min="1"
                        max="${item.stock}"
                        value="${item.qty}"
                        class="qty-input"
                        oninput="updateQty(${index}, this.value)"
                    >
                </td>
                <td>${item.price.toFixed(2)}</td>
                <td>${lineTotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="remove-btn" onclick="removeItem(${index})">×</button>
                </td>
            </tr>
        `;
    });

    updatePaymentSummary();
}

function prepareCart() {
    if (cart.length === 0) {
        alert('السلة فارغة');
        return false;
    }

    const total = calculateTotal();
    const paidDisplay = document.getElementById("paid_amount_display");
    const paidHidden = document.getElementById("paid_amount");

    let paid = parseFloat(paidDisplay.value);

    if (isNaN(paid) || paid < 0) {
        alert('ادخل مبلغ صحيح');
        return false;
    }

    if (paid > total) {
        alert('المبلغ المدفوع أكبر من إجمالي الفاتورة');
        return false;
    }

    paidHidden.value = paid;

    const hiddenInputs = document.getElementById("hiddenInputs");
    hiddenInputs.innerHTML = "";

    cart.forEach((item, index) => {
        hiddenInputs.innerHTML += `
            <input type="hidden" name="cart[${index}][id]" value="${item.id}">
            <input type="hidden" name="cart[${index}][qty]" value="${item.qty}">
        `;
    });

    return true;
}

document.getElementById('productSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    const items = document.querySelectorAll('.product-item');

    items.forEach(item => {
        const name = item.getAttribute('data-name');
        item.style.display = name.includes(value) ? '' : 'none';
    });
});

document.getElementById('paid_amount_display').addEventListener('input', updatePaymentSummary);

renderCart();
</script>

@endsection
