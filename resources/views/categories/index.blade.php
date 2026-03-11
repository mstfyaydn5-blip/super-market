@extends('layouts.app')

@section('content')
<style>
    .page-anim{ animation: fadeUp .35s ease both; }
    @keyframes fadeUp{ from{opacity:0; transform:translateY(10px)} to{opacity:1; transform:translateY(0)} }

    .card-soft{
        border:1px solid #e6e8ef;
        border-radius:16px;
        background:#fff;
        box-shadow:0 10px 25px rgba(0,0,0,.04);
    }

    .btn-soft{
        border-radius:12px;
        padding:.55rem .9rem;
        font-weight:800;
    }

    .btn-soft.btn-primary{
        box-shadow: 0 10px 20px rgba(37,99,235,.18);
    }

    .table thead th{
        background:#f7f8fb !important;
        border-bottom:1px solid #e6e8ef !important;
        font-weight:900;
        color:#374151;
        white-space: nowrap;
    }

    .row-hover tbody tr{ transition:.12s; }
    .row-hover tbody tr:hover{ background:#fbfcff; }

    .chip{
        display:inline-flex;
        align-items:center;
        gap:.35rem;
        padding:.35rem .6rem;
        border-radius:999px;
        border:1px solid #e6e8ef;
        background:#fff;
        font-weight:800;
        color:#374151;
    }

    .badge-soft{
        background:#f1f6ff;
        color:#2563eb;
        border:1px solid #dbe7ff;
        font-weight:900;
        border-radius:999px;
        padding:.35rem .55rem;
        white-space: nowrap;
    }

    .form-control{
        border-radius:12px;
        border:1px solid #e6e8ef;
        padding:.55rem .75rem;
    }

    .pagination{ justify-content:center; margin-bottom:0; }
    .page-link{ border-radius:10px !important; }
</style>

<div class="page-anim">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <div class="chip"><i class="bi bi-folder2"></i> الأصناف</div>
                <span class="text-muted small">إدارة الأصناف + عدد المنتجات بكل صنف</span>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-soft">
                <i class="bi bi-plus-lg"></i> إضافة صنف
            </a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-soft">
                <i class="bi bi-arrow-clockwise"></i> تحديث
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card-soft p-3 mb-3">
        <form method="GET" action="{{ route('categories.index') }}" class="row g-2 align-items-end">
            <div class="col-md-10">
                <label class="form-label mb-1">بحث</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="ابحث عن صنف...">
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary btn-soft">
                    <i class="bi bi-search"></i> بحث
                </button>
            </div>
        </form>
    </div>

    {{-- Summary --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <span class="badge-soft"><i class="bi bi-list-ul"></i> العدد الكلي: {{ $categories->total() }}</span>
        @if(request('search'))
            <a class="badge-soft text-decoration-none" href="{{ route('categories.index') }}">
                <i class="bi bi-x-circle"></i> إلغاء البحث
            </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="card-soft p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover row-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:80px">#</th>
                        <th>اسم الصنف</th>
                        <th style="width:160px" class="text-center">عدد المنتجات</th>
                        <th style="width:160px">تاريخ الإضافة</th>
                        <th style="width:120px" class="text-center">إجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $c)
                        <tr>
                            <td class="text-muted fw-bold">{{ $c->id }}</td>
                            <td class="fw-bold">{{ $c->name }}</td>

                            <td class="text-center">
                                <span class="badge-soft">
                                    {{ $c->products_count ?? 0 }} منتج
                                </span>
                            </td>

                            <td class="text-muted">
                                {{ optional($c->created_at)->format('Y-m-d') }}
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            {{-- إذا عندك صفحة show للصنف --}}
                                            @if(\Illuminate\Support\Facades\Route::has('categories.show'))
                                                <a class="dropdown-item" href="{{ route('categories.show', $c->id) }}">
                                                    <i class="bi bi-eye"></i> عرض
                                                </a>
                                            @endif
                                        </li>

                                        <li>
                                            <a class="dropdown-item" href="{{ route('categories.edit', $c->id) }}">
                                                <i class="bi bi-pencil-square"></i> تعديل
                                            </a>
                                        </li>

                                        <li><hr class="dropdown-divider"></li>

                                        <li>
                                            <form method="POST" action="{{ route('categories.destroy', $c->id) }}"
                                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash"></i> حذف
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox"></i> لا توجد أصناف
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 border-top" style="border-color:#e6e8ef !important;">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection
