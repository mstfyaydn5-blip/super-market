@extends('layouts.app')

@section('content')
<h4 class="mb-3">➕ إضافة صنف جديد</h4>

<form method="POST"
      action="{{ route('categories.store') }}"
      class="card p-4 shadow-sm">
    @csrf

    @include('categories._form')

    <div class="d-flex gap-2">
        <button class="btn btn-success">💾 حفظ</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">إلغاء</a>
    </div>
</form>
@endsection
