@extends('layouts.app')

@section('content')

<style>
    .enter{
        opacity: 0;
        transform: translateY(18px);
        animation: enter .55s ease forwards;
    }

    @keyframes enter{
        to{
            opacity: 1;
            transform: translateY(0);
        }
    }

    .d1{ animation-delay: .08s; }
    .d2{ animation-delay: .16s; }
    .d3{ animation-delay: .24s; }
    .d4{ animation-delay: .32s; }

    .stat-box{
        padding: 22px;
        border-radius: 16px;
        text-align: center;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(0,0,0,.05);
        transition: .2s ease;
        border: 1px solid #e6e8ef;
        background: #fff;
    }

    .stat-box:hover{
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(0,0,0,.07);
    }

    .stat-in{
        background: #ecfdf5;
        color: #059669;
    }

    .stat-out{
        background: #fef2f2;
        color: #dc2626;
    }

    .stat-balance{
        background: #eef2ff;
        color: #4338ca;
    }

    .stat-value{
        font-size: 30px;
        font-weight: 900;
        margin-top: 10px;
    }

    .cash-card{
        background: #fff;
        border: 1px solid #e6e8ef;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,.04);
        overflow: hidden;
    }

    .table thead th{
        background: #f7f8fb !important;
        border-bottom: 1px solid #e6e8ef !important;
        font-weight: 800;
        color: #374151;
    }

    .table tbody tr{
        transition: .12s ease;
    }

    .table tbody tr:hover{
        background: #fbfcff;
    }

    .counter{
        display: inline-block;
        min-width: 40px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 enter d1">
    <div>
        <h3 class="mb-0">صندوق الحساب</h3>
        <small class="text-muted">حركة الصندوق والرصيد الحالي</small>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 enter d2">
        <div class="stat-box stat-in">
            <div>إجمالي الداخل</div>
            <div class="stat-value">
                <span class="counter" data-target="{{ (int)$totalIn }}">0</span>
            </div>
        </div>
    </div>

    <div class="col-md-4 enter d3">
        <div class="stat-box stat-out">
            <div>إجمالي الخارج</div>
            <div class="stat-value">
                <span class="counter" data-target="{{ (int)$totalOut }}">0</span>
            </div>
        </div>
    </div>

    <div class="col-md-4 enter d4">
        <div class="stat-box stat-balance">
            <div>رصيد الصندوق</div>
            <div class="stat-value">
                <span class="counter" data-target="{{ (int)$balance }}">0</span>
            </div>
        </div>
    </div>
</div>

<div class="cash-card enter" style="animation-delay:.40s;">
    <div class="p-4 border-bottom" style="border-color:#e6e8ef !important;">
        <h5 class="mb-0">حركة الصندوق</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>النوع</th>
                    <th>المبلغ</th>
                    <th>الوصف</th>
                    <th>المرجع</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->date }}</td>
                        <td>
                            @if($t->type == 'in')
                                <span class="badge bg-success">داخل</span>
                            @else
                                <span class="badge bg-danger">خارج</span>
                            @endif
                        </td>
                        <td>{{ number_format($t->amount,2) }}</td>
                        <td>{{ $t->description ?? '-' }}</td>
                        <td>{{ $t->reference_type ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">لا توجد حركات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-3 border-top" style="border-color:#e6e8ef !important;">
        {{ $transactions->links() }}
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".counter").forEach(el => {
        const target = parseInt(el.dataset.target || 0);
        const duration = 1000;
        const start = performance.now();

        function animate(now){
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            const value = Math.floor(eased * target);
            el.textContent = value.toLocaleString();
            if(progress < 1){
                requestAnimationFrame(animate);
            }
        }

        requestAnimationFrame(animate);
    });
});
</script>

@endsection
