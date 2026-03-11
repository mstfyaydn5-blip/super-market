@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h3>دفعة للمورد</h3>
<small class="text-muted">{{ $supplier->name }}</small>
</div>

<a href="{{ route('suppliers.show',$supplier->id) }}" class="btn btn-secondary">
رجوع
</a>

</div>


<div class="card p-4">

<form method="POST" action="{{ route('supplier.payments.store') }}">

@csrf

<input type="hidden" name="supplier_id" value="{{ $supplier->id }}">

<div class="row g-3">

<div class="col-md-4">

<label class="form-label">المبلغ</label>

<input type="number" step="0.01" name="amount" class="form-control" required>

</div>


<div class="col-md-4">

<label class="form-label">تاريخ الدفع</label>

<input type="date" name="payment_date" class="form-control" required>

</div>


<div class="col-md-4">

<label class="form-label">طريقة الدفع</label>

<select name="payment_method" class="form-control">

<option value="cash">كاش</option>
<option value="bank">تحويل</option>

</select>

</div>


<div class="col-md-12">

<label class="form-label">ملاحظات</label>

<textarea name="notes" class="form-control"></textarea>

</div>


<div class="col-12">

<button class="btn btn-primary">

تسجيل الدفعة

</button>

</div>

</div>

</form>

</div>

@endsection
