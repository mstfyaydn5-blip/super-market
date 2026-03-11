@extends('layouts.app')

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

</style>


<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h3 class="mb-0">تعديل المورد</h3>
<small class="text-muted">تعديل بيانات المورد</small>
</div>

<a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-soft">
رجوع
</a>

</div>


<div class="card-soft p-4">

<form action="{{ route('suppliers.update',$supplier->id) }}" method="POST">

@csrf
@method('PUT')

<div class="row g-3">

<div class="col-md-6">

<label class="form-label">اسم المورد</label>

<input
type="text"
name="name"
class="form-control"
value="{{ $supplier->name }}"
required
>

</div>


<div class="col-md-6">

<label class="form-label">رقم الهاتف</label>

<input
type="text"
name="phone"
class="form-control"
value="{{ $supplier->phone }}"
>

</div>


<div class="col-md-6">

<label class="form-label">البريد الإلكتروني</label>

<input
type="email"
name="email"
class="form-control"
value="{{ $supplier->email }}"
>

</div>


<div class="col-md-6">

<label class="form-label">الرصيد الافتتاحي</label>

<input
type="number"
step="0.01"
name="opening_balance"
class="form-control"
value="{{ $supplier->opening_balance }}"
>

</div>


<div class="col-md-12">

<label class="form-label">العنوان</label>

<textarea
name="address"
class="form-control"
rows="2"
>{{ $supplier->address }}</textarea>

</div>


<div class="col-md-12">

<label class="form-label">ملاحظات</label>

<textarea
name="notes"
class="form-control"
rows="3"
>{{ $supplier->notes }}</textarea>

</div>


<div class="col-12 mt-3">

<button class="btn btn-primary btn-soft">

<i class="bi bi-check-lg"></i>
تعديل

</button>

</div>

</div>

</form>

</div>

@endsection
