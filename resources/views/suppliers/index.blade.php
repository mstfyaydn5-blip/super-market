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

.table th{
background:#f7f8fb !important;
}

.badge-balance{
background:#eef4ff;
color:#2563eb;
padding:4px 10px;
border-radius:20px;
font-weight:700;
}

</style>


<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h3 class="mb-0">الموردين</h3>
<small class="text-muted">إدارة الموردين</small>
</div>

<a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-soft">
<i class="bi bi-plus-lg"></i>
إضافة مورد
</a>

</div>


<div class="card-soft p-3 mb-3">

<form method="GET">

<div class="row g-2">

<div class="col-md-4">
<input
type="text"
name="search"
value="{{ request('search') }}"
class="form-control"
placeholder="بحث عن مورد..."
>
</div>

<div class="col-md-2">
<button class="btn btn-dark w-100">بحث</button>
</div>

</div>

</form>

</div>


<div class="card-soft p-3">

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>#</th>

<th>اسم المورد</th>

<th>الهاتف</th>

<th>البريد</th>

<th>الرصيد</th>

<th width="150">الإجراءات</th>

</tr>

</thead>

<tbody>

@forelse($suppliers as $supplier)

<tr>

<td>{{ $supplier->id }}</td>

<td>{{ $supplier->name }}</td>

<td>{{ $supplier->phone }}</td>

<td>{{ $supplier->email }}</td>

<td>
<span class="badge-balance">
{{ number_format($supplier->opening_balance,2) }}
</span>
</td>

<td>

<a href="{{ route('suppliers.show',$supplier->id) }}"
class="btn btn-sm btn-info">

عرض

</a>

<a href="{{ route('suppliers.edit',$supplier->id) }}"
class="btn btn-sm btn-warning">

تعديل

</a>

<form
action="{{ route('suppliers.destroy',$supplier->id) }}"
method="POST"
style="display:inline-block"
onsubmit="return confirm('هل أنت متأكد من الحذف؟')"
>

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">
حذف
</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center text-muted">

لا يوجد موردين

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-3">

{{ $suppliers->links() }}

</div>

</div>

@endsection
