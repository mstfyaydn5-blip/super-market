<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | عرض الفواتير
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $sales = Sale::with('customer')
            ->latest()
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }

    /*
    |--------------------------------------------------------------------------
    | إنشاء فاتورة
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $products = Product::where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('customers', 'products'));
    }

    /*
    |--------------------------------------------------------------------------
    | حفظ الفاتورة
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:cash,credit',
            'notes' => 'nullable|string',

            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0.01',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;

            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->quantity < $item['quantity']) {
                    DB::rollBack();

                    return back()->withInput()->withErrors([
                        'stock_error' => 'الكمية المطلوبة للمنتج "' . $product->name . '" غير متوفرة.'
                    ]);
                }

                $subtotal += $item['quantity'] * $item['price'];
            }

            $discount = (float) ($request->discount ?? 0);
            $paid = (float) ($request->paid_amount ?? 0);
            $total = $subtotal - $discount;

            if ($total < 0) {
                DB::rollBack();

                return back()->withInput()->withErrors([
                    'discount' => 'الخصم لا يمكن أن يكون أكبر من المجموع الفرعي.'
                ]);
            }

            $remaining = $total - $paid;

            if ($remaining < 0) {
                DB::rollBack();

                return back()->withInput()->withErrors([
                    'paid_amount' => 'المبلغ المدفوع أكبر من الإجمالي.'
                ]);
            }

            if ($paid == 0) {
                $status = 'unpaid';
            } elseif ($paid < $total) {
                $status = 'partial';
            } else {
                $status = 'paid';
            }

            $paymentMethod = $request->payment_method;
            if (!$paymentMethod && $paid > 0) {
                $paymentMethod = 'cash';
            }

            $lastSale = Sale::latest('id')->first();
            $nextNumber = $lastSale ? $lastSale->id + 1 : 1;
            $invoiceNumber = 'SAL-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $request->customer_id ?: null,
                'sale_date' => $request->sale_date,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'paid_amount' => $paid,
                'remaining_amount' => $remaining,
                'payment_status' => $status,
                'payment_method' => $paymentMethod,
                'notes' => $request->notes,
                'user_id' => Auth::id(),
            ]);

            foreach ($request->products as $item) {
    $product = Product::findOrFail($item['product_id']);
    $quantity = (int) $item['quantity'];
    $salePrice = (float) $item['price'];

    $lastPurchaseItem = \App\Models\PurchaseInvoiceItem::where('product_id', $product->id)
        ->latest('id')
        ->first();

    $costPrice = (float) ($lastPurchaseItem->purchase_price ?? 0);
    $lineTotal = $quantity * $salePrice;
    $profit = ($salePrice - $costPrice) * $quantity;

    SaleItem::create([
        'sale_id' => $sale->id,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'price' => $salePrice,
        'cost_price' => $costPrice,
        'total' => $lineTotal,
        'profit' => $profit,
    ]);

    $product->decrement('quantity', $quantity);
}

            if ($paid > 0) {
                CashTransaction::create([
                    'amount' => $paid,
                    'type' => 'in',
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'description' => 'فاتورة مبيعات ' . $sale->invoice_number,
                    'date' => $request->sale_date,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('sales.show', $sale->id)
                ->with('success', 'تم إنشاء الفاتورة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'error' => 'حدث خطأ أثناء حفظ الفاتورة: ' . $e->getMessage()
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | عرض فاتورة
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $sale = Sale::with(['customer', 'items.product', 'user'])->findOrFail($id);

        return view('sales.show', compact('sale'));
    }

    /*
    |--------------------------------------------------------------------------
    | حذف فاتورة
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $sale = Sale::with('items.product')->findOrFail($id);

            foreach ($sale->items as $item) {
                if ($item->product) {
                    $item->product->increment('quantity', $item->quantity);
                }
            }

            CashTransaction::where('reference_type', 'sale')
                ->where('reference_id', $sale->id)
                ->delete();

            $sale->delete();

            DB::commit();

            return redirect()
                ->route('sales.index')
                ->with('success', 'تم حذف الفاتورة وإرجاع الكميات للمخزن.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'حدث خطأ أثناء حذف الفاتورة: ' . $e->getMessage()
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | طباعة الفاتورة
    |--------------------------------------------------------------------------
    */
    public function print($id)
    {
        $sale = Sale::with(['customer', 'items.product', 'user'])->findOrFail($id);

        return view('sales.print', compact('sale'));
    }
}
