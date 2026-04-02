<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طباعة فاتورة البيع</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body{
            font-family: Tahoma, Arial, sans-serif;
            background:#fff;
            color:#111827;
            padding:30px;
        }
        .invoice-box{
            max-width:900px;
            margin:auto;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:30px;
        }
        .title{
            font-size:30px;
            font-weight:800;
            margin-bottom:5px;
        }
        .muted{
            color:#6b7280;
        }
        .table th, .table td{
            vertical-align:middle;
        }
        .summary-box{
            background:#f8fafc;
            border:1px solid #e5e7eb;
            border-radius:16px;
            padding:16px;
        }
        @media print {
            .no-print{
                display:none !important;
            }
            body{
                padding:0;
            }
            .invoice-box{
                border:none;
                box-shadow:none;
                max-width:100%;
                padding:0;
            }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <div class="title">فاتورة بيع</div>
            <div class="muted">سوبر ماركت</div>
        </div>

        <div class="text-start">
            <div><strong>رقم الفاتورة:</strong> {{ $sale->invoice_number }}</div>
            <div><strong>التاريخ:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}</div>
            <div><strong>العميل:</strong> {{ $sale->customer->name ?? 'زبون عام' }}</div>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>المجموع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? 'منتج محذوف' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            @if($sale->notes)
                <div class="summary-box">
                    <div class="fw-bold mb-2">ملاحظات</div>
                    <div>{{ $sale->notes }}</div>
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <div class="summary-box">
                <div class="d-flex justify-content-between mb-2">
                    <span>المجموع الفرعي</span>
                    <strong>{{ number_format($sale->subtotal, 2) }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>الخصم</span>
                    <strong>{{ number_format($sale->discount, 2) }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>الإجمالي</span>
                    <strong>{{ number_format($sale->total, 2) }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>المدفوع</span>
                    <strong>{{ number_format($sale->paid_amount, 2) }}</strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span>المتبقي</span>
                    <strong>{{ number_format($sale->remaining_amount, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-center muted">
        شكراً لتعاملكم معنا
    </div>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary px-4 rounded-pill">طباعة الفاتورة</button>
    </div>
</div>

</body>
</html>
