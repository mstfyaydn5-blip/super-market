@extends('layouts.app')

@section('content')

<style>
    .enter{ opacity:0; transform:translateY(20px); animation:enter .6s ease forwards; }
    @keyframes enter{ to{opacity:1;transform:translateY(0)} }

    .d1{animation-delay:.08s}
    .d2{animation-delay:.16s}
    .d3{animation-delay:.24s}
    .d4{animation-delay:.32s}
    .d5{animation-delay:.40s}
    .d6{animation-delay:.48s}
    .d7{animation-delay:.56s}
    .d8{animation-delay:.64s}
    .d9{animation-delay:.72s}
    .d10{animation-delay:.80s}

    .kpi{
        background:#fff;
        border-radius:15px;
        box-shadow:0 10px 25px rgba(0,0,0,.05);
        padding:20px;
        height: 100%;
        border:1px solid #e6e8ef;
        transition:.2s ease;
    }

    .kpi:hover{
        transform: translateY(-2px);
        box-shadow:0 14px 30px rgba(0,0,0,.07);
    }

    .kpi-label{
        color:#6b7280;
        font-size:14px;
        margin-bottom:8px;
    }

    .kpi-value{
        font-size:28px;
        font-weight:bold;
    }

    .panel{
        background:#fff;
        border-radius:15px;
        box-shadow:0 10px 25px rgba(0,0,0,.05);
        padding:20px;
        border:1px solid #e6e8ef;
        height: 100%;
    }

    .table thead th{
        background:#f7f8fb !important;
        white-space: nowrap;
    }

    .badge-soft{
        background:#eef4ff;
        color:#2563eb;
        padding:4px 10px;
        border-radius:999px;
        font-weight:700;
        border:1px solid #dbe7ff;
    }
</style>

<div class="container-fluid">

    <div class="mb-4 enter d1">
        <h3 class="mb-0">لوحة التحكم</h3>
        <small class="text-muted">ملخص المخزون والمحاسبة والنشاط</small>
    </div>


    <div class="row mb-4 g-3">
        <div class="col-md-3 enter d2">
            <div class="kpi text-center">
                <div class="kpi-label">عدد المنتجات</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$productsCount }}">0</span></div>
            </div>
        </div>

        <div class="col-md-3 enter d3">
            <div class="kpi text-center">
                <div class="kpi-label">عدد الأصناف</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$categoriesCount }}">0</span></div>
            </div>
        </div>

        <div class="col-md-3 enter d4">
            <div class="kpi text-center">
                <div class="kpi-label">إجمالي الكمية</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$totalStockQuantity }}">0</span></div>
            </div>
        </div>

        <div class="col-md-3 enter d5">
            <div class="kpi text-center">
                <div class="kpi-label">قيمة المخزون</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$totalStockValue }}">0</span></div>
                <small class="text-muted">تقريباً</small>
            </div>
        </div>
    </div>


    <div class="row mb-4 g-3">
        <div class="col-md-3 enter d5">
            <div class="kpi text-center">
                <div class="kpi-label">عدد الموردين</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$suppliersCount }}">0</span></div>
            </div>
        </div>

        <div class="col-md-3 enter d6">
            <div class="kpi text-center">
                <div class="kpi-label">عدد العملاء</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$customersCount }}">0</span></div>
            </div>
        </div>

        <div class="col-md-3 enter d7">
            <div class="kpi text-center">
                <div class="kpi-label">إجمالي الداخل</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$cashIn }}">0</span></div>
                <small class="text-muted">الصندوق</small>
            </div>
        </div>

        <div class="col-md-3 enter d8">
            <div class="kpi text-center">
                <div class="kpi-label">رصيد الصندوق</div>
                <div class="kpi-value"><span class="counter" data-target="{{ (int)$cashBalance }}">0</span></div>
                <small class="text-muted">داخل - خارج</small>
            </div>
        </div>
    </div>


    <div class="row g-3 mb-4">
        <div class="col-md-6 enter d6">
            <div class="panel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">قيمة المخزون حسب الصنف</h6>
                    <small class="text-muted">أعلى 8</small>
                </div>
                <canvas id="barChart" height="170"></canvas>
            </div>
        </div>

        <div class="col-md-6 enter d7">
            <div class="panel">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">المنتجات آخر 7 أيام</h6>
                    <small class="text-muted">حسب التاريخ</small>
                </div>
                <canvas id="lineChart" height="170"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 enter d8">
            <div class="panel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">منتجات قليلة المخزون</h6>
                    <small class="text-muted">أقل من {{ $lowStockThreshold }}</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th>الصنف</th>
                                <th class="text-end">الكمية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $p)
                                <tr>
                                    <td class="fw-semibold">{{ $p->name }}</td>
                                    <td class="text-muted">{{ optional($p->category)->name ?? '-' }}</td>
                                    <td class="text-end">
                                        <span class="badge text-bg-danger">{{ $p->quantity }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">لا يوجد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="col-md-6 enter d9">
            <div class="panel">
                <h6 class="mb-3">أحدث المنتجات</h6>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>المنتج</th>
                                <th>الصنف</th>
                                <th class="text-end">السعر</th>
                                <th class="text-end">الكمية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestProducts as $p)
                                <tr>
                                    <td class="fw-semibold">{{ $p->name }}</td>
                                    <td class="text-muted">{{ optional($p->category)->name ?? '-' }}</td>
                                    <td class="text-end">{{ number_format($p->price, 2) }}</td>
                                    <td class="text-end">{{ number_format($p->quantity) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">لا يوجد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-12 enter d10">
            <div class="panel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">آخر حركات الصندوق</h6>
                    <span class="badge-soft">أحدث 6 حركات</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
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
                            @forelse($latestCashTransactions as $t)
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td>{{ $t->date }}</td>
                                    <td>
                                        @if($t->type === 'in')
                                            <span class="badge bg-success">داخل</span>
                                        @else
                                            <span class="badge bg-danger">خارج</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($t->amount, 2) }}</td>
                                    <td>{{ $t->description ?? '-' }}</td>
                                    <td>{{ $t->reference_type ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">لا توجد حركات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll(".counter").forEach(el => {
        const target = parseInt(el.dataset.target || 0);
        const duration = 1200;
        const start = performance.now();

        function animate(now){
            const p = Math.min((now - start)/duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            const value = Math.floor(eased * target);
            el.textContent = value.toLocaleString();
            if(p < 1) requestAnimationFrame(animate);
        }
        requestAnimationFrame(animate);
    });

    const barLabels = @json($stockByCategory->pluck('category_name'));
    const barData   = @json($stockByCategory->pluck('stock_value'));

    const lineLabels = @json($last7DaysProducts->pluck('day'));
    const lineData   = @json($last7DaysProducts->pluck('total'));

    const barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: { labels: barLabels, datasets: [{ data: Array(barData.length).fill(0) }] },
        options: {
            animation:false,
            plugins:{legend:{display:false}},
            scales:{y:{beginAtZero:true}}
        }
    });

    const lineChart = new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: { labels: lineLabels, datasets: [{ data: Array(lineData.length).fill(0), tension:0.4 }] },
        options: {
            animation:false,
            plugins:{legend:{display:false}},
            scales:{y:{beginAtZero:true}}
        }
    });

    setTimeout(() => {
        barChart.data.datasets[0].data = barData;
        barChart.options.animation = { duration:1500, easing:'easeOutQuart' };
        barChart.update();

        lineChart.data.datasets[0].data = lineData;
        lineChart.options.animation = { duration:1500, easing:'easeOutQuart' };
        lineChart.update();
    }, 150);

});
</script>

@endsection
