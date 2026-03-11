@extends('layouts.app')

@section('content')

<h3 class="mb-4">إضافة عميل</h3>

<div class="card p-4">

<form method="POST" action="{{ route('customers.store') }}">

@csrf

<div class="mb-3">
<label>اسم العميل</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>الهاتف</label>
<input type="text" name="phone" class="form-control">
</div>

<div class="mb-3">
<label>البريد</label>
<input type="email" name="email" class="form-control">
</div>

<div class="mb-3">
<label>العنوان</label>
<textarea name="address" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>الرصيد الافتتاحي</label>
<input type="number" step="0.01" name="opening_balance" class="form-control" value="0">
</div>

<div class="mb-3">
<label>ملاحظات</label>
<textarea name="notes" class="form-control"></textarea>
</div>

<button class="btn btn-success">
حفظ
</button>

</form>

</div>

@endsection
