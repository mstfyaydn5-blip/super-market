@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h3 class="fw-bold mb-0">➕ إضافة منتج جديد</h3>
        <small class="text-muted">إضافة منتج إلى المخزن</small>
    </div>

    <a href="{{ request('return') ?? route('products.index') }}" class="btn btn-outline-secondary">
        ⬅ رجوع
    </a>
</div>


@if($categories->isEmpty())
<div class="alert alert-warning d-flex justify-content-between align-items-center shadow-sm">
    <div>⚠️ ماكو أصناف بعد. لازم تضيف صنف قبل ما تگدر تضيف منتج.</div>
    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-dark">➕ إضافة صنف</a>
</div>
@endif


<div class="row justify-content-center">
<div class="col-lg-9">

<div class="card border-0 shadow-sm">
<div class="card-body p-4">

<form method="POST"
      action="{{ route('products.store') }}"
      enctype="multipart/form-data">

@csrf


<div class="row g-3">

<div class="col-md-6">
<label class="form-label fw-semibold">اسم المنتج</label>

<input type="text"
       name="name"
       class="form-control"
       value="{{ old('name') }}"
       placeholder="مثال: بيبسي"
       required>
</div>


<div class="col-md-3">
<label class="form-label fw-semibold">السعر</label>

<input type="number"
       step="0.01"
       name="price"
       class="form-control"
       value="{{ old('price') }}"
       required>
</div>


<div class="col-md-3">
<label class="form-label fw-semibold">الكمية</label>

<input type="number"
       name="quantity"
       class="form-control"
       value="{{ old('quantity') }}"
       required>
</div>

</div>


<div class="mt-4">

<label class="form-label fw-semibold">الصنف</label>

<select name="category_id"
        class="form-select"
        required
        {{ $categories->isEmpty() ? 'disabled' : '' }}>

<option value="">-- اختر الصنف --</option>

@foreach($categories as $category)

<option value="{{ $category->id }}"
        @selected(old('category_id') == $category->id)>
        {{ $category->name }}
</option>

@endforeach

</select>

</div>


<hr class="my-4">


<div class="row g-3">

<div class="col-md-6">

<label class="form-label fw-semibold">الصورة الرئيسية</label>

<input type="file"
       name="image"
       class="form-control"
       accept="image/*">

<div class="form-text">
تظهر هذه الصورة في جدول المنتجات
</div>

</div>


<div class="col-md-6">

<label class="form-label fw-semibold">صور إضافية</label>

<input type="file"
       name="images[]"
       class="form-control"
       multiple
       accept="image/*">

<div class="form-text">
يمكنك اختيار أكثر من صورة
</div>

</div>

</div>


<div class="mt-4">

<label class="form-label fw-semibold">وصف المنتج</label>

<textarea name="description"
          id="description"
          class="form-control"
          rows="6">{{ old('description') }}</textarea>

</div>


<div class="d-flex gap-2 mt-4">

<button class="btn btn-primary px-4"
        {{ $categories->isEmpty() ? 'disabled' : '' }}>
💾 حفظ المنتج
</button>

<a href="{{ route('products.index') }}"
   class="btn btn-light border">
إلغاء
</a>

</div>


</form>

</div>
</div>

</div>
</div>

@endsection



@section('scripts')

<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<script>
CKEDITOR.replace('description', {
    language: 'ar',
    height: 200
});
</script>

@endsection
