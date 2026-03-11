@extends('layouts.app')

@section('content')
<style>
    /* ===== Animation (مثل الداشبورد) ===== */
    .enter{
        opacity:0;
        transform:translateY(14px);
        animation: enter .55s ease forwards;
        will-change: transform, opacity;
    }
    @keyframes enter{
        to{opacity:1; transform:translateY(0)}
    }
    .d1{ animation-delay:.05s } .d2{ animation-delay:.12s } .d3{ animation-delay:.18s }
    .d4{ animation-delay:.24s } .d5{ animation-delay:.30s } .d6{ animation-delay:.36s }
    .d7{ animation-delay:.42s } .d8{ animation-delay:.48s } .d9{ animation-delay:.54s }

    /* ===== UI ===== */
    .card-soft{
        border:1px solid #e6e8ef; border-radius:16px; background:#fff;
        box-shadow:0 10px 25px rgba(0,0,0,.04);
    }
    .btn-soft{ border-radius:12px; padding:.55rem .9rem; font-weight:800; }
    .btn-soft.btn-primary{ box-shadow:0 10px 20px rgba(37,99,235,.18); }
    .form-control, .form-select{
        border-radius:12px; border:1px solid #e6e8ef; padding:.55rem .75rem;
    }
    .chip{
        display:inline-flex; align-items:center; gap:.35rem;
        padding:.35rem .6rem; border-radius:999px;
        border:1px solid #e6e8ef; background:#fff;
        font-weight:800; color:#374151;
    }
    .badge-soft{
        background:#f1f6ff; color:#2563eb; border:1px solid #dbe7ff;
        font-weight:900; border-radius:999px; padding:.35rem .55rem;
        white-space:nowrap;
    }

    /* ===== Timeline ===== */
    .timeline{ position:relative; padding-right:18px; }
    .timeline:before{
        content:""; position:absolute; right:6px; top:0; bottom:0;
        width:2px; background:#edf0f5;
    }
    .t-item{ position:relative; padding:14px 14px 14px 10px; }
    .t-dot{
        position:absolute; right:0; top:22px;
        width:14px; height:14px; border-radius:50%;
        background:#2563eb; box-shadow:0 0 0 4px #e8f0ff;
    }
    .t-card{
        border:1px solid #e6e8ef; border-radius:14px; background:#fff;
        padding:12px 14px;
    }
    .t-title{ font-weight:900; margin-bottom:4px; }
    .t-meta{ color:#6b7280; font-size:12px; }

    .desc-ul{ margin:6px 0 0 0; padding-right:18px; }
    .desc-ul li{ margin-bottom:4px; color:#4b5563; }

    .pagination{ justify-content:center; margin-bottom:0; }
    .page-link{ border-radius:10px !important; }

    @media (prefers-reduced-motion: reduce){
        .enter{ animation:none; opacity:1; transform:none; }
    }
</style>

{{-- Header --}}
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 enter d1">
    <div class="d-flex align-items-center gap-2">
        <div class="chip"><i class="bi bi-receipt"></i> سجل الموظفين</div>
        <span class="text-muted small">متابعة نشاط الإضافة/التعديل/الحذف</span>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary btn-soft">
            <i class="bi bi-arrow-clockwise"></i> تحديث
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="card-soft p-3 mb-3 enter d2">
    <form method="GET" action="{{ route('activities.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label mb-1">بحث</label>
            <input class="form-control" name="q" value="{{ request('q') }}"
                   placeholder="مثال: إضافة / حذف / اسم منتج...">
        </div>

        <div class="col-md-3">
            <label class="form-label mb-1">نوع العملية</label>
            <select class="form-select" name="action">
                <option value="">الكل</option>
                <option value="create" @selected(request('action')=='create')>إضافة</option>
                <option value="update" @selected(request('action')=='update')>تعديل</option>
                <option value="delete" @selected(request('action')=='delete')>حذف</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label mb-1">من تاريخ</label>
            <input type="date" class="form-control" name="from" value="{{ request('from') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label mb-1">إلى تاريخ</label>
            <input type="date" class="form-control" name="to" value="{{ request('to') }}">
        </div>

        <div class="col-md-1 d-grid">
            <button class="btn btn-primary btn-soft"><i class="bi bi-funnel"></i></button>
        </div>
    </form>
</div>

<div class="d-flex flex-wrap gap-2 mb-3 enter d3">
    <span class="badge-soft"><i class="bi bi-list-ul"></i> العدد الكلي: {{ $activities->total() }}</span>
    @if(request()->hasAny(['q','action','from','to']))
        <a class="badge-soft text-decoration-none" href="{{ route('activities.index') }}">
            <i class="bi bi-x-circle"></i> إلغاء الفلاتر
        </a>
    @endif
</div>

{{-- Timeline --}}
<div class="card-soft p-3 enter d4">
    <div class="timeline">
        @forelse($activities as $i => $a)
            @php
                // اسم المستخدم من أكثر من مصدر
                $userName = $a->user->name ?? ($a->user_name ?? ($a->username ?? ($a->by_user ?? '—')));

                // نوع العملية
                $action = $a->action ?? ($a->type ?? ($a->event ?? ''));

                // الوصف قد يكون string أو array أو JSON
                $desc = $a->description ?? ($a->details ?? ($a->message ?? ''));

                // إذا string ويمثل JSON نحوله Array
                if (is_string($desc)) {
                    $try = json_decode($desc, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($try)) {
                        $desc = $try;
                    }
                }

                $when = optional($a->created_at)->format('Y-m-d H:i');

                $badgeTxt = $action;
                if($action==='create') $badgeTxt='إضافة';
                if($action==='update') $badgeTxt='تعديل';
                if($action==='delete') $badgeTxt='حذف';
                if(!$badgeTxt) $badgeTxt='عملية';

                // تأخير مختلف لكل عنصر (حتى يطلع واحد ورا الثاني)
                $delay = 0.08 + min($i, 8) * 0.06; // أقصى شي ~ 0.56s
            @endphp

            <div class="t-item enter" style="animation-delay: {{ number_format($delay, 2) }}s;">
                <span class="t-dot"></span>

                <div class="t-card">
                    <div class="d-flex justify-content-between align-items-center gap-2">
                        <div class="t-title">
                            {{ $userName }}
                            <span class="badge-soft ms-2">{{ $badgeTxt }}</span>
                        </div>
                        <div class="t-meta">{{ $when }}</div>
                    </div>

                    {{-- عرض الوصف بشكل آمن حتى لو Array --}}
                    @if(is_array($desc))
                        @if(count($desc))
                            <ul class="desc-ul">
                                @foreach($desc as $k => $v)
                                    <li>
                                        <strong>{{ is_string($k) ? $k : '—' }}:</strong>
                                        @if(is_array($v))
                                            {{ json_encode($v, JSON_UNESCAPED_UNICODE) }}
                                        @else
                                            {{ (string)$v }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-muted mt-1">—</div>
                        @endif
                    @else
                        <div class="text-muted mt-1">{{ (string)$desc ?: '—' }}</div>
                    @endif

                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4 enter d5">
                <i class="bi bi-inbox"></i> ماكو نشاط حالياً
            </div>
        @endforelse
    </div>

    <div class="pt-3 border-top enter d6" style="border-color:#e6e8ef !important;">
        {{ $activities->appends(request()->query())->links() }}
    </div>
</div>

@endsection
