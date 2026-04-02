<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\CashTransaction;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $suppliersCount = Supplier::count();
        $customersCount = Customer::count();
        $salesCount = Sale::count();

        $totalStockQuantity = (int) Product::sum('quantity');
        $totalStockValue = (float) Product::sum(DB::raw('price * quantity'));

        $cashIn = (float) CashTransaction::where('type', 'in')->sum('amount');
        $cashOut = (float) CashTransaction::where('type', 'out')->sum('amount');
        $cashBalance = $cashIn - $cashOut;

        $todaySales = (float) Sale::whereDate('sale_date', $today)->sum('total');
        $todayInvoicesCount = (int) Sale::whereDate('sale_date', $today)->count();

        $todayProfit = (float) SaleItem::whereHas('sale', function ($q) use ($today) {
            $q->whereDate('sale_date', $today);
        })->sum('profit');

        $lowStockThreshold = 10;

        $lowStockProducts = Product::with('category')
            ->where('quantity', '<', $lowStockThreshold)
            ->orderBy('quantity')
            ->take(6)
            ->get();

        $latestProducts = Product::with('category')
            ->latest()
            ->take(6)
            ->get();

        $stockByCategory = Category::leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->select(
                'categories.name as category_name',
                DB::raw('COALESCE(SUM(products.price * products.quantity), 0) as stock_value')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('stock_value')
            ->take(8)
            ->get();

        $salesLast7DaysRaw = Sale::select(
                DB::raw("DATE(sale_date) as day"),
                DB::raw("SUM(total) as total_sales")
            )
            ->whereDate('sale_date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $profitsLast7DaysRaw = SaleItem::select(
                DB::raw("DATE(sales.sale_date) as day"),
                DB::raw("SUM(sale_items.profit) as total_profit")
            )
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->whereDate('sales.sale_date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $last7DaysLabels = [];
        $last7DaysSales = [];
        $last7DaysProfits = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $last7DaysLabels[] = $date;
            $last7DaysSales[] = (float) ($salesLast7DaysRaw[$date]->total_sales ?? 0);
            $last7DaysProfits[] = (float) ($profitsLast7DaysRaw[$date]->total_profit ?? 0);
        }

        $topSellingProducts = SaleItem::join('products', 'products.id', '=', 'sale_items.product_id')
            ->select(
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_qty'),
                DB::raw('SUM(sale_items.total) as total_sales')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->take(6)
            ->get();

        $latestCashTransactions = CashTransaction::latest()
            ->take(6)
            ->get();

        $latestSales = Sale::with('customer')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'productsCount',
            'categoriesCount',
            'suppliersCount',
            'customersCount',
            'salesCount',
            'totalStockQuantity',
            'totalStockValue',
            'cashIn',
            'cashOut',
            'cashBalance',
            'todaySales',
            'todayInvoicesCount',
            'todayProfit',
            'lowStockThreshold',
            'lowStockProducts',
            'latestProducts',
            'stockByCategory',
            'last7DaysLabels',
            'last7DaysSales',
            'last7DaysProfits',
            'topSellingProducts',
            'latestCashTransactions',
            'latestSales'
        ));
    }
}
