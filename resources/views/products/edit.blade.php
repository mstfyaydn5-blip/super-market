@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="m-0">✏ تعديل المنتج</h4>
        <div class="text-muted small mt-1">
            تم الإنشاء: {{ optional($product->created_at)->format('Y-m-d H:i') }}
            • آخر تعديل: {{ optional($product->updated_at)->format('Y-m-d H:i') }}
        </div>
    </div>

    <a href="{{ request('return') ?? route('products.index', ['page' => request('page')]) }}"
       class="btn btn-secondary">
        ⬅ رجوع
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">

        {{-- فورم التعديل --}}
        <form method="POST"
              action="{{ route('products.update',$product) }}"
              enctype="multipart/form-data"
              class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            {{-- حتى يرجع نفس الصفحة --}}
            <input type="hidden" name="page" value="{{ request('page') }}">
            <input type="hidden" name="q" value="{{ request('q') }}">
            <input type="hidden" name="filter_category_id" value="{{ request('category_id') }}">
            <input type="hidden" name="from" value="{{ request('from') }}">
            <input type="hidden" name="to" value="{{ request('to') }}">

            @include('products._form', ['product' => $product, 'categories' => $categories])

            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-primary">💾 حفظ التعديلات</button>

                <a href="{{ request('return') ?? route('products.index', [
                        'page' => request('page'),
                        'q' => request('q'),
                        'category_id' => request('category_id'),
                        'from' => request('from'),
                        'to' => request('to'),
                    ]) }}"
                   class="btn btn-outline-secondary">
                    إلغاء
                </a>
            </div>
        </form>

        {{-- صور المعرض --}}
        @if($product->images->count())
            <div class="card p-4 shadow-sm mt-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="m-0">🖼 صور المعرض</h5>
                    <div class="text-muted small">اضغط ⭐ لتعيين صورة رئيسية</div>
                </div>

                <div class="row g-3">
                    @foreach($product->images as $img)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="border rounded p-2 text-center bg-white">
                                <img src="{{ asset('storage/'.$img->path) }}"
                                     class="img-fluid rounded"
                                     style="height:110px;object-fit:cover;width:100%;">

                                <div class="d-grid gap-2 mt-2">
                                    <form method="POST" action="{{ route('products.images.makeMain', [$product, $img]) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            ⭐ اجعلها رئيسية
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('products.images.destroy', [$product, $img]) }}"
                                          onsubmit="return confirm('هل أنت متأكد من حذف الصورة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            🗑 حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

@endsection
