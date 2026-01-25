@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="m-0">➕ إضافة منتج جديد</h4>
    <a href="{{ request('return') ?? route('products.index') }}" class="btn btn-secondary">⬅ رجوع</a>
</div>

@if($categories->isEmpty())
    <div class="alert alert-warning d-flex justify-content-between align-items-center">
        <div>⚠️ ماكو أصناف بعد. لازم تضيف صنف قبل ما تگدر تضيف منتج.</div>
        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-dark">➕ إضافة صنف</a>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">

        <form method="POST"
              action="{{ route('products.store') }}"
              enctype="multipart/form-data"
              class="card p-4 shadow-sm">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">اسم المنتج</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">السعر</label>
                    <input type="number" step="0.01" name="price" class="form-control"
                           value="{{ old('price') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">الكمية</label>
                    <input type="number" name="quantity" class="form-control"
                           value="{{ old('quantity') }}" required>
                </div>
            </div>


            <div class="mt-3">
                <label class="form-label">الصنف</label>
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
                    <label class="form-label">صورة رئيسية (تظهر بالجدول)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <div class="form-text">اختياري (إذا حبيت صورة Thumbnail).</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">صور إضافية (Gallery)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    <div class="form-text">تقدر تختار أكثر من صورة بنفس الوقت.</div>
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">وصف المنتج</label>
                <textarea name="description" id="description" class="form-control" rows="6">{{ old('description') }}</textarea>
            </div>


            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary"
                        {{ $categories->isEmpty() ? 'disabled' : '' }}>
                    💾 حفظ المنتج
                </button>

                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    إلغاء
                </a>
            </div>

        </form>

    </div>
</div>

@endsection
