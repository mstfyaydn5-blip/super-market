@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="m-0">📁 الأصناف</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-success">
        ➕ إضافة صنف
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

<form method="GET" action="{{ route('categories.index') }}" class="d-flex gap-2 mb-3">
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           class="form-control"
           placeholder="ابحث عن صنف...">
    <button class="btn btn-primary">بحث</button>

    @if(request('search'))
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">مسح</a>
    @endif
</form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th style="width:70px">#</th>
                        <th>اسم الصنف</th>
                        <th style="width:160px">عدد المنتجات</th>
                        <th style="width:240px" class="text-center">إجراءات</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($categories as $c)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="fw-bold">{{ $c->name }}</div>
                            <div class="text-muted small">ID: {{ $c->id }}</div>
                        </td>

                        <td>
                            <span class="badge bg-info text-dark px-3 py-2">
                                {{ $c->products_count }} منتج
                            </span>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('products.index', ['category_id' => $c->id]) }}"
                               class="btn btn-info btn-sm">
                                  📄 منتجات الصنف
                            </a>

                            <a class="btn btn-sm btn-warning"
                               href="{{ route('categories.edit', $c) }}">
                                ✏️ تعديل
                            </a>

                            <form class="d-inline"
                                  method="POST"
                                  action="{{ route('categories.destroy', $c) }}"
                                  onsubmit="return confirmDelete('متأكد تريد تحذف الصنف؟')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑 حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                           لا توجد اصناف حاليا
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>


        <div class="mt-3">
            {{ $categories->withQueryString()->links() }}
        </div>

    </div>
</div>
@endsection
