@extends('layouts.app')

@section('page_title', 'لوحة الإدارة')
@section('page_subtitle', 'لوحة متابعة احترافية للمبيعات، الأرباح، المخزون، وحركة الصندوق')

@section('content')

<style>
    .db-wrap{
        display:grid;
        gap:18px;
    }

    .db-enter{
        opacity:0;
        transform:translateY(18px);
        animation:dbEnter .55s ease forwards;
    }

    @keyframes dbEnter{
        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    .d1{animation-delay:.05s}
    .d2{animation-delay:.10s}
    .d3{animation-delay:.15s}
    .d4{animation-delay:.20s}
    .d5{animation-delay:.25s}
    .d6{animation-delay:.30s}
    .d7{animation-delay:.35s}
    .d8{animation-delay:.40s}
    .d9{animation-delay:.45s}
    .d10{animation-delay:.50s}
    .d11{animation-delay:.55s}
    .d12{animation-delay:.60s}

    .hero{
        position:relative;
        overflow:hidden;
        border:1px solid #e6e8ef;
        border-radius:26px;
        background:
            radial-gradient(circle at top left, rgba(37,99,235,.10), transparent 28%),
            radial-gradient(circle at bottom right, rgba(22,163,74,.08), transparent 24%),
            linear-gradient(135deg,#ffffff 0%,#f7faff 100%);
        box-shadow:0 18px 40px rgba(0,0,0,.05);
        padding:24px;
    }

    .hero::after{
        content:"";
        position:absolute;
        inset:auto -40px -40px auto;
        width:180px;
        height:180px;
        border-radius:50%;
        background:radial-gradient(circle, rgba(37,99,235,.08), transparent 65%);
        pointer-events:none;
    }

    .hero-title{
        font-size:30px;
        font-weight:900;
        color:#0f172a;
        margin-bottom:6px;
    }

    .hero-subtitle{
        color:#6b7280;
        font-size:14px;
        max-width:720px;
    }

    .hero-grid{
        display:grid;
        grid-template-columns:1.8fr 1fr;
        gap:18px;
        align-items:stretch;
    }

    .hero-badges{
        display:flex;
        flex-wrap:wrap;
        gap:10px;
        margin-top:16px;
    }

    .hero-chip{
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:10px 14px;
        border-radius:999px;
        background:#fff;
        border:1px solid #e3e9f3;
        font-size:13px;
        font-weight:800;
        color:#334155;
        box-shadow:0 8px 18px rgba(0,0,0,.03);
    }

    .hero-side{
        display:grid;
        gap:12px;
    }

    .hero-mini{
        background:rgba(255,255,255,.92);
        border:1px solid #e6e8ef;
        border-radius:20px;
        padding:16px;
        box-shadow:0 10px 24px rgba(0,0,0,.04);
    }

    .hero-mini-label{
        color:#64748b;
        font-size:12px;
        font-weight:800;
        margin-bottom:6px;
    }

    .hero-mini-value{
        font-size:28px;
        font-weight:900;
        color:#111827;
        line-height:1;
    }

    .hero-mini-note{
        margin-top:8px;
        color:#6b7280;
        font-size:12px;
    }

    .section-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        margin-bottom:10px;
    }

    .section-head h5{
        margin:0;
        font-weight:900;
        color:#111827;
    }

    .section-head small{
        color:#6b7280;
        font-weight:700;
    }

    .quick-link{
        display:block;
        height:100%;
        padding:18px;
        border-radius:20px;
        background:#fff;
        border:1px solid #e6e8ef;
        box-shadow:0 10px 24px rgba(0,0,0,.04);
        transition:.18s ease;
        color:inherit;
    }

    .quick-link:hover{
        transform:translateY(-3px);
        background:#f9fbff;
        box-shadow:0 16px 30px rgba(0,0,0,.06);
    }

    .quick-icon{
        width:46px;
        height:46px;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#eef4ff;
        color:#2563eb;
        border:1px solid #dce8ff;
        font-size:19px;
        margin-bottom:12px;
    }

    .quick-title{
        font-weight:900;
        color:#0f172a;
        margin-bottom:4px;
    }

    .quick-sub{
        color:#6b7280;
        font-size:13px;
    }

    .metric-card{
        position:relative;
        overflow:hidden;
        background:#fff;
        border:1px solid #e6e8ef;
        border-radius:20px;
        padding:18px;
        height:100%;
        box-shadow:0 10px 24px rgba(0,0,0,.04);
        transition:.18s ease;
    }

    .metric-card:hover{
        transform:translateY(-3px);
        box-shadow:0 16px 32px rgba(0,0,0,.06);
    }

    .metric-card::before{
        content:"";
        position:absolute;
        top:0;
        right:0;
        width:100%;
        height:4px;
        background:linear-gradient(90deg,#2563eb,#60a5fa);
        opacity:.9;
    }

    .metric-green::before{ background:linear-gradient(90deg,#16a34a,#4ade80); }
    .metric-orange::before{ background:linear-gradient(90deg,#ea580c,#fb923c); }
    .metric-red::before{ background:linear-gradient(90deg,#dc2626,#f87171); }
    .metric-purple::before{ background:linear-gradient(90deg,#7c3aed,#a78bfa); }

    .metric-top{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        margin-bottom:14px;
    }

    .metric-icon{
        width:48px;
        height:48px;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:20px;
        background:#eef4ff;
        color:#2563eb;
        border:1px solid #dce8ff;
    }

    .metric-green .metric-icon{
        background:#ecfdf3;
        color:#16a34a;
        border-color:#c7f0d8;
    }

    .metric-orange .metric-icon{
        background:#fff7ed;
        color:#ea580c;
        border-color:#fed7aa;
    }

    .metric-red .metric-icon{
        background:#fef2f2;
        color:#dc2626;
        border-color:#fecaca;
    }

    .metric-purple .metric-icon{
        background:#f5f3ff;
        color:#7c3aed;
        border-color:#ddd6fe;
    }

    .metric-label{
        color:#6b7280;
        font-size:13px;
        font-weight:800;
    }

    .metric-value{
        font-size:30px;
        font-weight:900;
        color:#111827;
        line-height:1.05;
    }

    .metric-foot{
        margin-top:10px;
        color:#6b7280;
        font-size:12px;
    }

    .panel{
        background:#fff;
        border:1px solid #e6e8ef;
        border-radius:20px;
        padding:18px;
        height:100%;
        box-shadow:0 10px 24px rgba(0,0,0,.04);
    }

    .panel-soft{
        background:linear-gradient(180deg,#ffffff 0%,#fbfcff 100%);
    }

    .chart-wrap{
        position:relative;
        min-height:290px;
    }

    .table thead th{
        background:#f7f8fb !important;
        color:#334155;
        font-weight:900;
        white-space:nowrap;
        border-bottom:1px solid #e6e8ef !important;
    }

    .table td, .table th{
        vertical-align:middle;
    }

    .mini{
        font-size:12px;
        color:#6b7280;
    }

    .badge-soft{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:5px 10px;
        border-radius:999px;
        background:#eef4ff;
        color:#2563eb;
        border:1px solid #dce8ff;
        font-size:12px;
        font-weight:900;
    }

    .badge-soft.green{
        background:#ecfdf3;
        color:#15803d;
        border-color:#c7f0d8;
    }

    .badge-soft.red{
        background:#fef2f2;
        color:#dc2626;
        border-color:#fecaca;
    }

    .empty-state{
        text-align:center;
        padding:28px 10px;
        color:#6b7280;
        font-weight:700;
    }

    @media (max-width: 991px){
        .hero-grid{
            grid-template-columns:1fr;
        }

        .chart-wrap{
            min-height:240px;
        }
    }
</style>

<div class="db-wrap">

    <div class="hero db-enter d1">
        <div class="hero-grid">
            <div>
                <div class="hero-title">Cockpit Dashboard</div>
                <div class="hero-subtitle">
                    متابعة مباشرة لحركة النظام: المبيعات، الأرباح، المخزون، والصندوق، بشكل سريع وواضح مثل لوحات الإدارة الاحترافية.
                </div>

                <div class="hero-badges">
                    <div class="hero-chip">
                        <i class="bi bi-calendar-event"></i>
                        <span>{{ now()->format('Y-m-d') }}</span>
                    </div>
                    <div class="hero-chip">
                        <i class="bi bi-clock-history"></i>
                        <span>{{ now()->format('H:i') }}</span>
                    </div>
                    <div class="hero-chip">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>الفواتير الكلية: {{ number_format($salesCount) }}</span>
                    </div>
                    <div class="hero-chip">
                        <i class="bi bi-people"></i>
                        <span>العملاء: {{ number_format($customersCount) }}</span>
                    </div>
                </div>
            </div>

            <div class="hero-side">
                <div class="hero-mini">
                    <div class="hero-mini-label">مبيعات اليوم</div>
                    <div class="hero-mini-value">
                        <span class="counter" data-target="{{ (int)$todaySales }}">0</span>
                    </div>
                    <div class="hero-mini-note">إجمالي البيع لهذا اليوم</div>
                </div>

                <div class="hero-mini">
                    <div class="hero-mini-label">أرباح اليوم</div>
                    <div class="hero-mini-value">
                        <span class="counter" data-target="{{ (int)$todayProfit }}">0</span>
                    </div>
                    <div class="hero-mini-note">صافي الربح اليومي</div>
                </div>
            </div>
        </div>
    </div>

    <div class="db-enter d2">
        <div class="section-head">
            <h5>إجراءات سريعة</h5>
            <small>تنقل سريع لأكثر المهام استخدامًا</small>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <a href="{{ route('pos.index') }}" class="quick-link">
                    <div class="quick-icon"><i class="bi bi-cart-check"></i></div>
                    <div class="quick-title">فتح الكاشير</div>
                    <div class="quick-sub">بدء عملية بيع جديدة بسرعة</div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('sales.index') }}" class="quick-link">
                    <div class="quick-icon"><i class="bi bi-receipt-cutoff"></i></div>
                    <div class="quick-title">الفواتير</div>
                    <div class="quick-sub">متابعة جميع فواتير البيع</div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('profits.index') }}" class="quick-link">
                    <div class="quick-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    <div class="quick-title">الأرباح</div>
                    <div class="quick-sub">تقارير الربح اليومية والشاملة</div>
                </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('cash.index') }}" class="quick-link">
                    <div class="quick-icon"><i class="bi bi-wallet2"></i></div>
                    <div class="quick-title">الصندوق</div>
                    <div class="quick-sub">حركة الداخل والخارج</div>
                </a>
            </div>
        </div>
    </div>

    <div class="db-enter d3">
        <div class="section-head">
            <h5>المؤشرات الذكية</h5>
            <small>أهم الأرقام بنظرة واحدة</small>
        </div>

        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <div class="metric-card metric-green">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">مبيعات اليوم</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$todaySales }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-cash-coin"></i></div>
                    </div>
                    <div class="metric-foot">إجمالي البيع الحالي</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="metric-card metric-purple">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">أرباح اليوم</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$todayProfit }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-graph-up"></i></div>
                    </div>
                    <div class="metric-foot">صافي الربح الفعلي</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="metric-card metric-orange">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">فواتير اليوم</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$todayInvoicesCount }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-receipt"></i></div>
                    </div>
                    <div class="metric-foot">عدد عمليات البيع اليومية</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="metric-card metric-red">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">رصيد الصندوق</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$cashBalance }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-safe2"></i></div>
                    </div>
                    <div class="metric-foot">الصافي الحالي</div>
                </div>
            </div>
        </div>
    </div>

    <div class="db-enter d4">
        <div class="section-head">
            <h5>المخزون والمحاسبة</h5>
            <small>صورة شاملة للنظام</small>
        </div>

        <div class="row g-3">
            <div class="col-lg-2 col-md-4">
                <div class="metric-card">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">المنتجات</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$productsCount }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-box-seam"></i></div>
                    </div>
                    <div class="metric-foot">كل المواد المخزنية</div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <div class="metric-card">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">الأصناف</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$categoriesCount }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-folder2-open"></i></div>
                    </div>
                    <div class="metric-foot">تصنيفات المنتجات</div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <div class="metric-card">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">الموردين</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$suppliersCount }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-truck"></i></div>
                    </div>
                    <div class="metric-foot">عدد الموردين</div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <div class="metric-card">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">العملاء</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$customersCount }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-people"></i></div>
                    </div>
                    <div class="metric-foot">عدد العملاء</div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <div class="metric-card">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">إجمالي الكمية</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$totalStockQuantity }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-stack"></i></div>
                    </div>
                    <div class="metric-foot">الكمية المتوفرة</div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4">
                <div class="metric-card">
                    <div class="metric-top">
                        <div>
                            <div class="metric-label">قيمة المخزون</div>
                            <div class="metric-value"><span class="counter" data-target="{{ (int)$totalStockValue }}">0</span></div>
                        </div>
                        <div class="metric-icon"><i class="bi bi-currency-dollar"></i></div>
                    </div>
                    <div class="metric-foot">القيمة الحالية</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 db-enter d5">
        <div class="col-xl-8">
            <div class="panel panel-soft">
                <div class="section-head">
                    <h5>حركة المبيعات والأرباح</h5>
                    <small>آخر 7 أيام</small>
                </div>
                <div class="chart-wrap">
                    <canvas id="salesProfitChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="panel">
                <div class="section-head">
                    <h5>قيمة المخزون حسب الصنف</h5>
                    <small>أعلى 8 أصناف</small>
                </div>
                <div class="chart-wrap">
                    <canvas id="stockBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 db-enter d6">
        <div class="col-md-6">
            <div class="panel">
                <div class="section-head">
                    <h5>أكثر المنتجات مبيعًا</h5>
                    <small>أفضل المنتجات حركة</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th class="text-end">الكمية</th>
                                <th class="text-end">إجمالي البيع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topSellingProducts as $item)
                                <tr>
                                    <td class="fw-semibold">{{ $item->name }}</td>
                                    <td class="text-end">{{ number_format($item->total_qty) }}</td>
                                    <td class="text-end">{{ number_format($item->total_sales, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">لا توجد بيانات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel">
                <div class="section-head">
                    <h5>منتجات قليلة المخزون</h5>
                    <small>أقل من {{ $lowStockThreshold }}</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
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
                                    <td class="mini">{{ optional($p->category)->name ?? '-' }}</td>
                                    <td class="text-end">
                                        <span class="badge-soft red">{{ $p->quantity }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">لا يوجد</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 db-enter d7">
        <div class="col-md-6">
            <div class="panel">
                <div class="section-head">
                    <h5>آخر الفواتير</h5>
                    <small>أحدث 6 فواتير</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>الإجمالي</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestSales as $sale)
                                <tr>
                                    <td>
                                        <span class="badge-soft">{{ $sale->invoice_number ?? ('#' . $sale->id) }}</span>
                                    </td>
                                    <td>{{ $sale->customer->name ?? '-' }}</td>
                                    <td>{{ number_format($sale->total, 2) }}</td>
                                    <td class="mini">{{ optional($sale->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">لا توجد فواتير</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel">
                <div class="section-head">
                    <h5>آخر حركات الصندوق</h5>
                    <small>أحدث 6 حركات</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>التاريخ</th>
                                <th>النوع</th>
                                <th>المبلغ</th>
                                <th>الوصف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestCashTransactions as $t)
                                <tr>
                                    <td>{{ $t->id }}</td>
                                    <td>{{ $t->date }}</td>
                                    <td>
                                        @if($t->type === 'in')
                                            <span class="badge-soft green">داخل</span>
                                        @else
                                            <span class="badge-soft red">خارج</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($t->amount, 2) }}</td>
                                    <td class="mini">{{ $t->description ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">لا توجد حركات</td>
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
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".counter").forEach(el => {
        const target = parseInt(el.dataset.target || 0);
        const duration = 1200;
        const start = performance.now();

        function animate(now){
            const p = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            const value = Math.floor(eased * target);
            el.textContent = value.toLocaleString();
            if (p < 1) requestAnimationFrame(animate);
        }

        requestAnimationFrame(animate);
    });

    const labels = @json($last7DaysLabels);
    const salesData = @json($last7DaysSales);
    const profitsData = @json($last7DaysProfits);

    const stockLabels = @json($stockByCategory->pluck('category_name'));
    const stockValues = @json($stockByCategory->pluck('stock_value'));

    new Chart(document.getElementById('salesProfitChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'المبيعات',
                    data: salesData,
                    tension: 0.35,
                    borderWidth: 3,
                    fill: false
                },
                {
                    label: 'الأرباح',
                    data: profitsData,
                    tension: 0.35,
                    borderWidth: 3,
                    fill: false
                }
            ]
        },
        options: {
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{ display:true }
            },
            scales:{
                y:{ beginAtZero:true }
            }
        }
    });

    new Chart(document.getElementById('stockBarChart'), {
        type: 'bar',
        data: {
            labels: stockLabels,
            datasets: [{
                label: 'قيمة المخزون',
                data: stockValues,
                borderRadius: 8
            }]
        },
        options: {
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{ display:false }
            },
            scales:{
                y:{ beginAtZero:true }
            }
        }
    });
});
</script>

@endsection
