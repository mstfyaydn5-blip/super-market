@extends('layouts.app')

@section('content')
<h4 class="mb-3">✏️ تعديل الصنف</h4>

<form method="POST"
      action="{{ route('categories.update', $category) }}"
      class="card p-4 shadow-sm">
    @csrf
    @method('PUT')

    @include('categories._form', ['category' => $category])

    <div class="d-flex gap-2">
        <button class="btn btn-primary">💾 حفظ التعديل</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">إلغاء</a>
    </div>
</form>
@endsection
