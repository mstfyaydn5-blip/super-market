
<div class="mb-3">
    <label class="form-label">اسم المنتج</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $product->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">السعر</label>
    <input type="number" step="0.01" name="price" class="form-control"
           value="{{ old('price', $product->price ?? '') }}" required>
</div>


<div class="mb-3">
    <label class="form-label">الكمية</label>
    <input type="number" name="quantity" class="form-control"
           value="{{ old('quantity', $product->quantity ?? '') }}" required>
</div>


<div class="mb-3">
    <label class="form-label">الصنف</label>
    <select name="category_id" class="form-select" required>
        @foreach($categories as $c)
            <option value="{{ $c->id }}"
                @selected(old('category_id', $product->category_id ?? '') == $c->id)>
                {{ $c->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">صورة رئيسية للمنتج</label>
    <input type="file" name="image" class="form-control">

    @if(!empty($product?->image))
        <img src="{{ asset('storage/'.$product->image) }}" class="mt-2 rounded" width="120">
    @endif
</div>


<div class="mb-3">
    <label class="form-label">صور إضافية (Gallery)</label>
    <input type="file" name="images[]" class="form-control" multiple>
    <div class="form-text">تقدر تختار أكثر من صورة بنفس الوقت.</div>
</div>



<div class="mb-3">
    <label class="form-label">وصف المنتج</label>

    <div id="desc-editor" style="height: 180px; background:#fff;"></div>


    <textarea name="description" id="description" class="d-none">
        {{ old('description', $product->description ?? '') }}
    </textarea>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editorEl = document.getElementById('desc-editor');
    const textarea = document.getElementById('desc');

    if (!editorEl || !textarea) return;

    const quill = new Quill('#desc-editor', {
        theme: 'snow',
        placeholder: 'اكتب وصف المنتج...',
        modules: {
            toolbar: [
                ['bold','italic','underline'],
                [{'list':'ordered'},{'list':'bullet'}],
                [{'align':[]}],
                ['link'],
                ['clean']
            ]
        }
    });


    quill.root.innerHTML = textarea.value || '';


    const form = editorEl.closest('form');
    form.addEventListener('submit', function () {
        textarea.value = quill.root.innerHTML;
    });
});
</script>
@endpush
