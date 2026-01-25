@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="m-0">📦 تفاصيل المنتج</h4>


</div>


<div class="card shadow-sm p-4">
    <div class="row g-4">


        <div class="col-md-4">


            @if($product->image)
                <div class="border rounded bg-white p-2 mb-3 text-center">
                    <img id="mainProductImage"
                         src="{{ asset('storage/'.$product->image) }}"
                         class="img-fluid rounded"
                         style="width:100%;height:280px;object-fit:cover;cursor:pointer"
                         data-bs-toggle="modal" data-bs-target="#imgModal">
                </div>
            @endif


            @if($product->images->count())
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    @foreach($product->images as $img)
                        <img
                            src="{{ asset('storage/'.$img->path) }}"
                            class="rounded border"
                            style="width:70px;height:70px;object-fit:cover;cursor:pointer"
                            onclick="setMainImage('{{ asset('storage/'.$img->path) }}')"
                        >
                    @endforeach
                </div>
            @elseif(!$product->image)
                <div class="text-muted text-center">لا توجد صور</div>
            @endif

        </div>

        <div class="col-md-8">

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-white">
                        <div class="text-muted small">اسم المنتج</div>
                        <div class="fw-semibold">{{ $product->name }}</div>
                    </div>
                </div>


               <p>
                 <strong>أضيف بواسطة:</strong>
                   {{ $product->user->name ?? '-' }}
               </p>

                <p>
                 <strong>آخر تعديل بواسطة:</strong>
                   {{ $product->updatedBy->name ?? 'لم يتم التعديل' }}
                </p>


                <div class="col-md-3">
                    <div class="p-3 border rounded bg-white">
                        <div class="text-muted small">السعر</div>
                        <div class="fw-semibold">{{ $product->price }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 border rounded bg-white">
                        <div class="text-muted small">الكمية</div>
                        <div class="fw-semibold">{{ $product->quantity }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded bg-white">
                        <div class="text-muted small">الصنف</div>
                        <div class="fw-semibold">{{ optional($product->category)->name ?? 'بدون صنف' }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 border rounded bg-white">
                        <div class="text-muted small">تاريخ الإضافة</div>
                        <div class="fw-semibold">{{ optional($product->created_at)->format('Y-m-d H:i') }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="p-3 border rounded bg-white">
                        <div class="text-muted small">آخر تعديل</div>
                        <div class="fw-semibold">{{ optional($product->updated_at)->format('Y-m-d H:i') }}</div>
                    </div>
                </div>
            </div>


            <div class="mt-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="fw-semibold">📝 وصف المنتج</div>
                </div>

                <div class="border rounded bg-white p-3 desc-box">
                    @if(!empty($product->description))
                        <div class="ql-snow">
                            <div class="ql-editor" style="padding:0; direction: rtl; text-align:right;">
                                {!! $product->description !!}
                            </div>
                        </div>
                    @else
                        <div class="text-muted">لا يوجد وصف</div>
                    @endif
                </div>
            </div>


            <div class="mt-4 d-flex gap-2 flex-wrap">
                <a href="{{ route('products.edit',$product) }}?from=show&return={{ urlencode(request('return', url()->previous())) }}"
                   class="btn btn-warning">
                    ✏ تعديل
                </a>

                <form method="POST" action="{{ route('products.destroy',$product) }}"
                      onsubmit="return confirm('هل أنت متأكد من حذف المنتج؟')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">🗑 حذف</button>
                </form>

                @php
                 $backUrl = request('return') ?: route('products.index');
                @endphp

                 <a href="{{ $backUrl }}" class="btn btn-secondary">⬅ رجوع</a>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="imgModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body p-2">
        <img id="modalProductImage" src="" class="img-fluid rounded w-100">
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function setMainImage(src){
    const main = document.getElementById('mainProductImage');
    const modal = document.getElementById('modalProductImage');
    if(main) main.src = src;
    if(modal) modal.src = src;
}

document.addEventListener('DOMContentLoaded', () => {
    const main = document.getElementById('mainProductImage');
    const modal = document.getElementById('modalProductImage');
    if(main && modal) modal.src = main.src;
});
</script>
@endpush
@endsection
