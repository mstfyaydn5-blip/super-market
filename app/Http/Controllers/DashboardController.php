<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\CashTransaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $suppliersCount = Supplier::count();
        $customersCount = Customer::count();

        $totalStockQuantity = (int) Product::sum('quantity');
        $totalStockValue = (float) Product::sum(DB::raw('price * quantity'));

        $lowStockThreshold = 10;

        $lowStockProducts = Product::with('category')
            ->where('quantity', '<', $lowStockThreshold)
            ->orderBy('quantity')
            ->take(8)
            ->get();

        $latestProducts = Product::with('category')
            ->latest()
            ->take(8)
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

        $last7DaysProducts = Product::select(
                DB::raw("DATE(created_at) as day"),
                DB::raw("COUNT(*) as total")
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $cashIn = (float) CashTransaction::where('type', 'in')->sum('amount');
        $cashOut = (float) CashTransaction::where('type', 'out')->sum('amount');
        $cashBalance = $cashIn - $cashOut;

        $latestCashTransactions = CashTransaction::latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'productsCount',
            'categoriesCount',
            'suppliersCount',
            'customersCount',
            'totalStockQuantity',
            'totalStockValue',
            'lowStockThreshold',
            'lowStockProducts',
            'latestProducts',
            'stockByCategory',
            'last7DaysProducts',
            'cashIn',
            'cashOut',
            'cashBalance',
            'latestCashTransactions'
        ));
    }
}
