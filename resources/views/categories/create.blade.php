@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h3 class="fw-bold mb-0">➕ إضافة صنف جديد</h3>
<small class="text-muted">إضافة صنف لمنتجات المتجر</small>
</div>

<a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
⬅ رجوع
</a>

</div>


<div class="row justify-content-center">
<div class="col-lg-6">

<form method="POST"
      action="{{ route('categories.store') }}"
      class="card border-0 shadow-sm">

@csrf

<div class="card-body p-4">

@include('categories._form')

<div class="d-flex gap-2 mt-4">

<button class="btn btn-primary px-4">
💾 حفظ
</button>

<a href="{{ route('categories.index') }}"
   class="btn btn-light border">
إلغاء
</a>

</div>

</div>

</form>

</div>
</div>

@endsection
