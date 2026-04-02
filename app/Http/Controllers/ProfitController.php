<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $query = SaleItem::with(['sale', 'product']);

        if ($from) {
            $query->whereHas('sale', function ($q) use ($from) {
                $q->whereDate('sale_date', '>=', $from);
            });
        }

        if ($to) {
            $query->whereHas('sale', function ($q) use ($to) {
                $q->whereDate('sale_date', '<=', $to);
            });
        }

        $items = $query->orderByDesc('id')->paginate(20);

        $totalSales = (clone $query)->sum('total');
        $totalProfit = (clone $query)->sum('profit');
        $totalCost = (clone $query)->sum(DB::raw('cost_price * quantity'));

        return view('profits.index', compact(
            'items',
            'from',
            'to',
            'totalSales',
            'totalProfit',
            'totalCost'
        ));
    }
}
