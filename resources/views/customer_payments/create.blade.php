@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h3>دفعة من العميل</h3>
<small>{{ $customer->name }}</small>
</div>

<a href="{{ route('customers.show',$customer->id) }}" class="btn btn-secondary">
رجوع
</a>

</div>

<div class="card p-4">

<form method="POST" action="{{ route('customer.payments.store') }}">

@csrf

<input type="hidden" name="customer_id" value="{{ $customer->id }}">

<div class="row g-3">

<div class="col-md-4">

<label>المبلغ</label>

<input type="number" step="0.01" name="amount" class="form-control" required>

</div>


<div class="col-md-4">

<label>تاريخ الدفع</label>

<input type="date" name="payment_date" class="form-control" required>

</div>


<div class="col-md-4">

<label>طريقة الدفع</label>

<select name="payment_method" class="form-control">

<option value="cash">كاش</option>
<option value="bank">تحويل</option>

</select>

</div>


<div class="col-md-12">

<label>ملاحظات</label>

<textarea name="notes" class="form-control"></textarea>

</div>

<div class="col-12">

<button class="btn btn-success">
تسجيل الدفعة
</button>

</div>

</div>

</form>

</div>

@endsection
