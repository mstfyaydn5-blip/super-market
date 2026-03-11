@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h3>العملاء</h3>
<small class="text-muted">إدارة العملاء</small>
</div>

<a href="{{ route('customers.create') }}" class="btn btn-primary">
إضافة عميل
</a>

</div>


<div class="card p-4">

<table class="table table-hover">

<thead>
<tr>
<th>#</th>
<th>اسم العميل</th>
<th>الهاتف</th>
<th>الرصيد</th>
<th>الإجراءات</th>
</tr>
</thead>

<tbody>

@foreach($customers as $customer)

<tr>

<td>{{ $customer->id }}</td>

<td>{{ $customer->name }}</td>

<td>{{ $customer->phone }}</td>

<td>{{ number_format($customer->opening_balance,2) }}</td>

<td>

<a href="{{ route('customers.show',$customer->id) }}" class="btn btn-info btn-sm">
عرض
</a>

<a href="{{ route('customers.edit',$customer->id) }}" class="btn btn-warning btn-sm">
تعديل
</a>

<form action="{{ route('customers.destroy',$customer->id) }}" method="POST" style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
حذف
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $customers->links() }}

</div>

@endsection
