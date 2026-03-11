@extends('layouts.app')

@section('content')

<h3 class="mb-4">{{ $customer->name }}</h3>

<div class="row mb-4">

<div class="col-md-4">
<div class="card p-3 text-center">
الرصيد الافتتاحي
<br><br>
{{ number_format($customer->opening_balance,2) }}
</div>
</div>

<div class="col-md-4">
<div class="card p-3 text-center">
إجمالي الدفعات
<br><br>
{{ number_format($totalPayments,2) }}
</div>
</div>

<div class="col-md-4">
<div class="card p-3 text-center">
الرصيد الحالي
<br><br>
{{ number_format($currentBalance,2) }}
</div>
</div>

</div>

<a href="{{ route('customer.payments.create',$customer->id) }}" class="btn btn-success mb-3">
إضافة دفعة
</a>

<div class="card p-4">

<h5>كشف الحساب</h5>

<table class="table">

<thead>
<tr>
<th>#</th>
<th>التاريخ</th>
<th>المبلغ</th>
<th>طريقة الدفع</th>
<th>ملاحظات</th>
</tr>
</thead>

<tbody>

@foreach($payments as $p)

<tr>

<td>{{ $p->id }}</td>

<td>{{ $p->payment_date }}</td>

<td>{{ number_format($p->amount,2) }}</td>

<td>{{ $p->payment_method }}</td>

<td>{{ $p->notes }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection
