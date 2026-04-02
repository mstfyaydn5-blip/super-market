<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\PurchaseInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
        $invoices = PurchaseInvoice::with('supplier')
            ->latest()
            ->paginate(15);

        return view('purchases.index', compact('invoices'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'invoice_date' => ['required', 'date'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'paid' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.purchase_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;

            foreach ($request->items as $item) {
                $subtotal += ((float) $item['quantity'] * (float) $item['purchase_price']);
            }

            $discount = (float) ($request->discount ?? 0);
            $total = max($subtotal - $discount, 0);
            $paid = (float) ($request->paid ?? 0);
            $remaining = max($total - $paid, 0);

            $supplier = Supplier::findOrFail($request->supplier_id);

            $invoice = PurchaseInvoice::create([
                'supplier_id'    => $request->supplier_id,
                'invoice_number' => 'PUR-' . now()->format('YmdHis'),
                'invoice_date'   => $request->invoice_date,
                'subtotal'       => $subtotal,
                'discount'       => $discount,
                'total'          => $total,
                'paid'           => $paid,
                'remaining'      => $remaining,
                'notes'          => $request->notes,
                'user_id'        => auth()->id(),
            ]);

            foreach ($request->items as $item) {
                $lineTotal = (float) $item['quantity'] * (float) $item['purchase_price'];

                $invoice->items()->create([
                    'product_id'     => $item['product_id'],
                    'quantity'       => $item['quantity'],
                    'purchase_price' => $item['purchase_price'],
                    'total'          => $lineTotal,
                ]);

                $product = Product::findOrFail($item['product_id']);
                $product->quantity = (float) $product->quantity + (float) $item['quantity'];
                $product->save();
            }

            // تحديث رصيد المورد
            $supplier->balance = (float) $supplier->balance + $remaining;
            $supplier->save();

            // تسجيل حركة بالصندوق إذا كان عندك موديل Cash
            if ($paid > 0 && class_exists(\App\Models\Cash::class)) {
                \App\Models\Cash::create([
                    'type' => 'expense',
                    'amount' => $paid,
                    'description' => 'دفعة فاتورة شراء رقم ' . $invoice->invoice_number . ' للمورد: ' . $supplier->name,
                    'date' => $request->invoice_date,
                ]);
            }
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'تم حفظ فاتورة الشراء وتحديث المخزون ورصيد المورد بنجاح.');
    }

    public function show(PurchaseInvoice $purchase)
    {
        $purchase->load(['supplier', 'items.product', 'user']);

        return view('purchases.show', compact('purchase'));
    }
}
