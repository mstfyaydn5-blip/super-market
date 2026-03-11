@extends('layouts.app')

@section('content')
<div class="card-soft p-4">
    <h4 class="mb-3">
        <i class="bi bi-folder2"></i> {{ $category->name }}
    </h4>

    <p class="text-muted">عدد المنتجات: {{ $category->products->count() }}</p>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                </tr>
            </thead>
            <tbody>
                @forelse($category->products as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td>{{ number_format($p->price,2) }}</td>
                        <td>{{ $p->quantity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">لا توجد منتجات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
