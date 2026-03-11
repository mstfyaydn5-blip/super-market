@extends('layouts.app')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">👤 منتجاتي</h3>
        <small class="text-muted">المنتجات التي قمت بإضافتها</small>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
        ⬅ كل المنتجات
    </a>
</div>


<form method="GET" action="{{ route('products.mine') }}" class="card border-0 shadow-sm p-3 mb-4">

<div class="row g-2 align-items-end">

<div class="col-md-4">
<label class="form-label">بحث</label>

<input type="text"
       name="search"
       class="form-control"
       value="{{ request('search') }}"
       placeholder="بحث عن منتج...">

</div>


<div class="col-md-3">

<label class="form-label">الصنف</label>

<select name="category_id" class="form-select">

<option value="">كل الأصناف</option>

@foreach($categories as $c)

<option value="{{ $c->id }}"
        @selected(request('category_id') == $c->id)>
        {{ $c->name }}
</option>

@endforeach

</select>

</div>


<div class="col-md-2">

<label class="form-label">من تاريخ</label>

<input type="date"
       name="from"
       class="form-control"
       value="{{ request('from') }}">

</div>


<div class="col-md-2">

<label class="form-label">إلى تاريخ</label>

<input type="date"
       name="to"
       class="form-control"
       value="{{ request('to') }}">

</div>


<div class="col-md-1 d-grid">
<button class="btn btn-primary">تطبيق</button>
</div>


<div class="col-md-12 d-flex justify-content-end">
<a href="{{ route('products.mine') }}" class="btn btn-outline-secondary btn-sm">
تصفير
</a>
</div>

</div>

</form>



<div class="card border-0 shadow-sm">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>

<th style="width:60px">#</th>
<th style="width:90px">صورة</th>
<th>الاسم</th>
<th style="width:160px">أضيف بواسطة</th>
<th style="width:160px">آخر تعديل</th>
<th style="width:110px">السعر</th>
<th style="width:110px">الكمية</th>
<th style="width:150px">الصنف</th>
<th style="width:120px">تاريخ الإضافة</th>
<th style="width:120px">آخر تعديل</th>
<th style="width:200px">إجراءات</th>

</tr>

</thead>


<tbody>

@forelse($products as $i => $p)

<tr>

<td class="fw-bold">
{{ $products->firstItem() + $i }}
</td>


<td>

@if($p->image)

<img src="{{ asset('storage/'.$p->image) }}"
     class="rounded border"
     style="width:60px;height:60px;object-fit:cover;">

@else

<span class="text-muted">—</span>

@endif

</td>


<td class="fw-semibold">
{{ $p->name }}
</td>


<td>

@if($p->user)

<span class="badge bg-info text-dark">
{{ $p->user->name }}
</span>

@else

<span class="text-muted">غير معروف</span>

@endif

</td>


<td>

@if($p->updatedBy)

<span class="badge bg-warning text-dark">
{{ $p->updatedBy->name }}
</span>

@else

<span class="text-muted">—</span>

@endif

</td>


<td>
{{ number_format($p->price, 2) }}
</td>


<td>
{{ $p->quantity }}
</td>


<td>
{{ optional($p->category)->name ?? '-' }}
</td>


<td>
{{ optional($p->created_at)->format('Y-m-d') }}
</td>


<td>
{{ optional($p->updated_at)->format('Y-m-d') }}
</td>


<td class="d-flex flex-wrap gap-1">

<a class="btn btn-outline-info btn-sm"
   href="{{ route('products.show', $p) }}?return={{ urlencode(request()->fullUrl()) }}">
👁 عرض
</a>


<a class="btn btn-outline-warning btn-sm"
   href="{{ route('products.edit', $p) }}?return={{ urlencode(request()->fullUrl()) }}">
✏ تعديل
</a>


<form method="POST"
      action="{{ route('products.destroy',$p) }}"
      onsubmit="return confirmDelete()">

@csrf
@method('DELETE')

<button class="btn btn-outline-danger btn-sm">
🗑 حذف
</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="11" class="text-center text-muted py-4">
ما عندك منتجات بعد.
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>



@if($products->count())

<div class="d-flex flex-wrap justify-content-between align-items-center mt-3">

<div class="text-muted small">

عرض
{{ $products->firstItem() }}
إلى
{{ $products->lastItem() }}
من أصل
{{ $products->total() }}
منتج

</div>


<div>

{{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}

</div>

</div>

@endif

@endsection
