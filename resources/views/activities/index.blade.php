@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h4 class="m-0">📋 سجل الموظفين</h4>
            <div class="text-muted small mt-1">
                المجموع: <strong>{{ $activities->total() }}</strong> حركة
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ url()->current() }}?{{ http_build_query(request()->query()) }}" class="btn btn-outline-primary">
                🔄 تحديث
            </a>
            <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary">
                🧹 مسح الفلاتر
            </a>
        </div>
    </div>


    <form method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-md-3">
            <label class="form-label">الموظف</label>
            <select name="user_id" class="form-select">
                <option value="">الكل</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" @selected(request('user_id') == $u->id)>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">نوع الحركة</label>
            <select name="action" class="form-select">
                <option value="">الكل</option>
                @foreach($actions as $key => $label)
                    <option value="{{ $key }}" @selected(request('action') == $key)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">من</label>
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">إلى</label>
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">بحث بالمنتج</label>
            <input type="text" name="q" class="form-control" placeholder="اسم المنتج..."
                   value="{{ request('q') }}">
        </div>

        <div class="col-12 d-flex gap-2 mt-2">
            <button class="btn btn-primary">فلتر</button>
            <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary">مسح</a>
        </div>
    </form>


    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 160px;">الوقت</th>
                        <th style="width: 180px;">الموظف</th>
                        <th style="width: 160px;">الحركة</th>
                        <th>المنتج</th>
                        <th style="width: 260px;">تفاصيل</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($activities as $a)
                    @php
                        $label = $actions[$a->action] ?? $a->action;


                        $badge = match($a->action) {
                            'created' => 'bg-success',
                            'updated' => 'bg-warning text-dark',
                            'deleted' => 'bg-danger',
                            'image_added' => 'bg-info text-dark',
                            'image_deleted' => 'bg-secondary',
                            'main_image_changed' => 'bg-primary',
                            default => 'bg-light text-dark',
                        };

                        $productName = $a->product->name ?? ($a->details['name'] ?? null);
                    @endphp

                    <tr>
                        <td>
                            <div>{{ $a->created_at->format('Y-m-d') }}</div>
                            <div class="small text-muted">{{ $a->created_at->format('H:i') }}</div>
                        </td>

                        <td>
                            <div class="fw-semibold">{{ $a->user->name ?? '—' }}</div>
                            <div class="small text-muted">ID: {{ $a->user_id ?? '—' }}</div>
                        </td>

                        <td>
                            <span class="badge {{ $badge }}">{{ $label }}</span>
                        </td>

                        <td>
                            @if($a->product)
                                <div class="d-flex align-items-center gap-2">
                                    <a class="text-decoration-none fw-semibold"
                                       href="{{ route('products.show', $a->product->id) }}">
                                        {{ $a->product->name }}
                                    </a>

                                    <a class="btn btn-sm btn-outline-primary"
                                       href="{{ route('products.show', $a->product_id) }}?return={{ urlencode(url()->full()) }}">
                                     عرض
                                    </a>

                                </div>

                                <div class="small text-muted">#{{ $a->product_id }}</div>
                            @else
                                <span class="text-muted">منتج محذوف</span>
                                @if($productName)
                                    <div class="small text-muted">({{ $productName }})</div>
                                @endif
                            @endif
                        </td>

                        <td>
                            @if(is_array($a->details) && !empty($a->details))
                                <details>
                                    <summary class="text-primary">عرض التفاصيل</summary>


                                    @if(isset($a->details['old']) && isset($a->details['new']))
                                        <div class="mt-2 small">
                                            <div class="fw-semibold mb-1">التغييرات:</div>

                                            @foreach($a->details['new'] as $key => $newVal)
                                                @php $oldVal = $a->details['old'][$key] ?? null; @endphp
                                                <div class="mb-1">
                                                    <span class="text-muted">{{ $key }}:</span>
                                                    <span class="text-danger">{{ is_array($oldVal) ? json_encode($oldVal, JSON_UNESCAPED_UNICODE) : $oldVal }}</span>
                                                    →
                                                    <span class="text-success">{{ is_array($newVal) ? json_encode($newVal, JSON_UNESCAPED_UNICODE) : $newVal }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <pre class="m-0 mt-2 small">{{ json_encode($a->details, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                    @endif
                                </details>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">لا توجد حركات.</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

        <div class="card-body">
            {{ $activities->links() }}
        </div>
    </div>

</div>
@endsection
