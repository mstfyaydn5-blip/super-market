@extends('layouts.app')

@section('content')

<style>

.card-soft{
border:1px solid #e6e8ef;
border-radius:16px;
background:#fff;
box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.stat-box{
padding:20px;
border-radius:12px;
text-align:center;
font-weight:700;
}

.stat-open{
background:#eef2ff;
color:#4f46e5;
}

.stat-pay{
background:#ecfdf5;
color:#059669;
}

.stat-balance{
background:#fff7ed;
color:#ea580c;
}

</style>

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h3 class="mb-0">{{ $supplier->name }}</h3>
<small class="text-muted">كشف حساب المورد</small>
</div>

<div>

<a href="{{ route('supplier.payments.create',$supplier->id) }}"
class="btn btn-success">

إضافة دفعة

</a>

<a href="{{ route('suppliers.index') }}"
class="btn btn-secondary">

رجوع

</a>

</div>

</div>

<div class="row g-3 mb-4">

<div class="col-md-4">

<div class="stat-box stat-open">

الرصيد الافتتاحي

<br><br>

{{ number_format($supplier->opening_balance,2) }}

</div>

</div>


<div class="col-md-4">

<div class="stat-box stat-pay">

إجمالي الدفعات

<br><br>

{{ number_format($totalPayments,2) }}

</div>

</div>


<div class="col-md-4">

<div class="stat-box stat-balance">

الرصيد الحالي

<br><br>

{{ number_format($currentBalance,2) }}

</div>

</div>

</div>


<div class="card-soft p-4">

<h5 class="mb-3">كشف الحساب</h5>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>#</th>

<th>التاريخ</th>

<th>نوع العملية</th>

<th>المبلغ</th>

<th>طريقة الدفع</th>

<th>ملاحظات</th>

</tr>

</thead>

<tbody>

@forelse($payments as $payment)

<tr>

<td>{{ $payment->id }}</td>

<td>{{ $payment->payment_date }}</td>

<td>

<span class="badge bg-success">

دفعة

</span>

</td>

<td>

{{ number_format($payment->amount,2) }}

</td>

<td>

{{ $payment->payment_method }}

</td>

<td>

{{ $payment->notes }}

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center text-muted">

لا يوجد عمليات

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection
