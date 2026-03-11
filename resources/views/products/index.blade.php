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

    .table td, .table th{ vertical-align: middle !important; }

    .avatar-img{
        width:46px; height:46px;
        border-radius:14px;
        object-fit:cover;
        border:1px solid #e6e8ef;
        background:#fff;
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

    .badge-low{
        background:#fff7ed;
        color:#9a3412;
        border:1px solid #fed7aa;
        font-weight:900;
        border-radius:999px;
        padding:.35rem .55rem;
        white-space: nowrap;
    }

    .badge-out{
        background:#fee2e2;
        color:#991b1b;
        border:1px solid #fecaca;
        font-weight:900;
        border-radius:999px;
        padding:.35rem .55rem;
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

    .form-control, .form-select{
        border-radius:12px;
        border:1px solid #e6e8ef;
        padding:.55rem .75rem;
    }

    /* ✅ Pagination RTL مرتب */
    .pagination{ justify-content: center; margin-bottom: 0; }
    .page-link{ border-radius:10px !important; }
</style>

<div class="page-anim">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <div class="chip"><i class="bi bi-box-seam"></i> المنتجات</div>
                <span class="text-muted small">إدارة وعرض المنتجات مع فلاتر وبحث</span>
            </div>
        </div>

        <div class="d-flex gap-2">
            {{-- ✅ زر بنفس ألوان المشروع --}}
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-soft">
                <i class="bi bi-plus-lg"></i> إضافة منتج
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-soft">
                <i class="bi bi-arrow-clockwise"></i> تحديث
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card-soft p-3 mb-3">
        <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-end">

            <div class="col-md-4">
                <label class="form-label mb-1">بحث</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="ابحث عن منتج...">
            </div>

            <div class="col-md-3">
                <label class="form-label mb-1">الصنف</label>
                <select name="category_id" class="form-select">
                    <option value="">كل الأصناف</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label mb-1">من تاريخ</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label mb-1">إلى تاريخ</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>

            <div class="col-md-1 d-grid">
                <button class="btn btn-primary btn-soft">
                    <i class="bi bi-funnel"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Summary --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <span class="badge-soft"><i class="bi bi-list-ul"></i> العدد الكلي: {{ $products->total() }}</span>

        @if(request('search') || request('category_id') || request('from') || request('to'))
            <a class="badge-soft text-decoration-none" href="{{ route('products.index') }}">
                <i class="bi bi-x-circle"></i> إلغاء الفلاتر
            </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="card-soft p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover row-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:70px">#</th>
                        <th style="width:90px">صورة</th>
                        <th>الاسم</th>
                        <th>الصنف</th>
                        <th class="text-end">السعر</th>
                        <th class="text-end">الكمية</th>
                        <th style="width:140px">تاريخ الإضافة</th>
                        <th style="width:120px" class="text-center">إجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $p)
                        <tr>
                            <td class="text-muted fw-bold">{{ $p->id }}</td>

                            <td>
                                @php $img = $p->image ?? null; @endphp
                                @if($img)
                                    <img class="avatar-img" src="{{ asset('storage/'.$img) }}" alt="img">
                                @else
                                    <div class="avatar-img d-flex align-items-center justify-content-center text-muted">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="fw-bold">{{ $p->name }}</td>

                            <td>
                                <span class="badge-soft">
                                    {{ optional($p->category)->name ?? '—' }}
                                </span>
                            </td>

                            <td class="text-end fw-bold">{{ number_format($p->price, 2) }}</td>

                            <td class="text-end">
                                @if($p->quantity <= 0)
                                    <span class="badge-out"><i class="bi bi-x-circle"></i> نفد</span>
                                @elseif($p->quantity < 10)
                                    <span class="badge-low"><i class="bi bi-exclamation-triangle"></i> {{ $p->quantity }}</span>
                                @else
                                    <span class="badge-soft">{{ $p->quantity }}</span>
                                @endif
                            </td>

                            <td class="text-muted">{{ optional($p->created_at)->format('Y-m-d') }}</td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('products.show', $p->id) }}">
                                                <i class="bi bi-eye"></i> عرض
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('products.edit', $p->id) }}">
                                                <i class="bi bi-pencil-square"></i> تعديل
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('products.destroy', $p->id) }}"
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
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox"></i> لا توجد بيانات
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ✅ Pagination داخل نفس الكارد ومرتب Bootstrap --}}
        <div class="p-3 border-top" style="border-color:#e6e8ef !important;">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection
