@extends('layouts.app')

@section('content')
<h4 class="mb-3">📁 تفاصيل الصنف</h4>

<div class="card p-4 shadow-sm">
    <p class="mb-2"><strong>اسم الصنف:</strong> {{ $category->name }}</p>
    <p class="mb-3"><strong>عدد المنتجات:</strong> {{ $category->products_count ?? 0 }}</p>

    <div class="d-flex gap-2">
        <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="btn btn-info">
            🧾 عرض منتجات الصنف
        </a>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">✏️ تعديل</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">⬅️ رجوع</a>
    </div>
</div>
@endsection
