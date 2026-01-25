@php
    $isEdit = isset($category);
@endphp

<div class="mb-3">
    <label class="form-label">اسم الصنف</label>
    <input type="text"
           name="name"
           class="form-control"
           value="{{ old('name', $isEdit ? $category->name : '') }}"
           placeholder="مثال: مشروبات / خضروات..."
           required>
</div>
