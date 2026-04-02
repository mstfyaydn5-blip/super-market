<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CashTransaction;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $customers = Customer::orderBy('name')->get();

        return view('pos.index', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|in:cash,credit',
            'paid_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'sale_date' => 'nullable|date',
            'discount' => 'nullable|numeric|min:0',
        ], [
            'cart.required' => 'السلة فارغة.',
            'cart.array' => 'بيانات السلة غير صحيحة.',
            'cart.min' => 'أضف منتج واحد على الأقل.',
            'customer_id.required' => 'يرجى اختيار عميل.',
            'customer_id.exists' => 'العميل المحدد غير موجود.',
            'payment_method.required' => 'يرجى اختيار طريقة الدفع.',
            'payment_method.in' => 'طريقة الدفع غير صحيحة.',
            'paid_amount.required' => 'يرجى إدخال المبلغ المدفوع.',
            'paid_amount.numeric' => 'المدفوع يجب أن يكون رقم.',
            'paid_amount.min' => 'المدفوع لا يمكن أن يكون أقل من صفر.',
            'sale_date.date' => 'تاريخ البيع غير صحيح.',
            'discount.numeric' => 'الخصم يجب أن يكون رقم.',
            'discount.min' => 'الخصم لا يمكن أن يكون أقل من صفر.',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;

            foreach ($request->cart as $item) {
                $product = Product::findOrFail($item['id']);
                $qty = (int) $item['qty'];

                if ($qty < 1) {
                    DB::rollBack();
                    return back()->with('error', 'كمية المنتج يجب أن تكون 1 على الأقل.');
                }

                if ($product->quantity < $qty) {
                    DB::rollBack();
                    return back()->with('error', 'الكمية غير كافية للمنتج: ' . $product->name);
                }

                $subtotal += ((float) $product->price * $qty);
            }

            $discount = (float) ($request->discount ?? 0);
            $paid = (float) $request->paid_amount;
            $saleDate = $request->sale_date ?: now()->toDateString();
            $total = $subtotal - $discount;

            if ($total < 0) {
                DB::rollBack();
                return back()->with('error', 'الخصم لا يمكن أن يكون أكبر من مجموع الفاتورة.');
            }

            if ($paid > $total) {
                DB::rollBack();
                return back()->with('error', 'المبلغ المدفوع أكبر من إجمالي الفاتورة.');
            }

            $remaining = $total - $paid;

            if ($paid <= 0) {
                $status = 'unpaid';
            } elseif ($paid < $total) {
                $status = 'partial';
            } else {
                $status = 'paid';
            }

            $lastSale = Sale::latest('id')->first();
            $nextNumber = $lastSale ? $lastSale->id + 1 : 1;
            $invoiceNumber = 'SAL-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $sale = Sale::create([
                'invoice_number'   => $invoiceNumber,
                'customer_id'      => $request->customer_id,
                'sale_date'        => $saleDate,
                'subtotal'         => $subtotal,
                'discount'         => $discount,
                'total'            => $total,
                'paid_amount'      => $paid,
                'remaining_amount' => $remaining,
                'payment_status'   => $status,
                'payment_method'   => $request->payment_method,
                'notes'            => $request->notes,
                'user_id'          => Auth::id(),
            ]);

            foreach ($request->cart as $item) {
    $product = Product::findOrFail($item['id']);
    $qty = (int) $item['qty'];
    $price = (float) $product->price;

    $lastPurchaseItem = \App\Models\PurchaseInvoiceItem::where('product_id', $product->id)
        ->latest('id')
        ->first();

    $costPrice = (float) ($lastPurchaseItem->purchase_price ?? 0);
    $lineTotal = $price * $qty;
    $profit = ($price - $costPrice) * $qty;

    SaleItem::create([
        'sale_id'    => $sale->id,
        'product_id' => $product->id,
        'quantity'   => $qty,
        'price'      => $price,
        'cost_price' => $costPrice,
        'total'      => $lineTotal,
        'profit'     => $profit,
    ]);

    $product->decrement('quantity', $qty);
}

            if ($paid > 0) {
                CashTransaction::create([
                    'amount'         => $paid,
                    'type'           => 'in',
                    'reference_type' => 'sale',
                    'reference_id'   => $sale->id,
                    'description'    => 'بيع من الكاشير - ' . $sale->invoice_number,
                    'date'           => $saleDate,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('sales.show', $sale->id)
                ->with('success', 'تمت عملية البيع بنجاح');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'صار خطأ أثناء الحفظ: ' . $e->getMessage());
        }
    }
}
