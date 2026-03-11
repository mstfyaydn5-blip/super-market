@extends('layouts.app')

@section('content')

<h3 class="mb-4">تعديل العميل</h3>

<div class="card p-4">

<form method="POST" action="{{ route('customers.update',$customer->id) }}">

@csrf
@method('PUT')

<div class="mb-3">
<label>اسم العميل</label>
<input type="text" name="name" value="{{ $customer->name }}" class="form-control">
</div>

<div class="mb-3">
<label>الهاتف</label>
<input type="text" name="phone" value="{{ $customer->phone }}" class="form-control">
</div>

<div class="mb-3">
<label>البريد</label>
<input type="email" name="email" value="{{ $customer->email }}" class="form-control">
</div>

<div class="mb-3">
<label>العنوان</label>
<textarea name="address" class="form-control">{{ $customer->address }}</textarea>
</div>

<div class="mb-3">
<label>الرصيد الافتتاحي</label>
<input type="number" step="0.01" name="opening_balance" value="{{ $customer->opening_balance }}" class="form-control">
</div>

<div class="mb-3">
<label>ملاحظات</label>
<textarea name="notes" class="form-control">{{ $customer->notes }}</textarea>
</div>

<button class="btn btn-primary">
تحديث
</button>

</form>

</div>

@endsection
