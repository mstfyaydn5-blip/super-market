<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\PurchaseInvoice;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    public function create($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);

        $purchases = PurchaseInvoice::where('supplier_id', $supplier->id)
            ->where('remaining', '>', 0)
            ->orderByDesc('invoice_date')
            ->get();

        return view('supplier_payments.create', compact('supplier', 'purchases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'     => 'required|exists:suppliers,id',
            'purchase_id'     => 'required|exists:purchase_invoices,id',
            'amount'          => 'required|numeric|min:0.01',
            'payment_date'    => 'required|date',
            'payment_method'  => 'nullable|string',
            'notes'           => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, &$payment) {
            $supplier = Supplier::findOrFail($request->supplier_id);

            $purchase = PurchaseInvoice::where('id', $request->purchase_id)
                ->where('supplier_id', $request->supplier_id)
                ->firstOrFail();

            if ((float)$purchase->remaining <= 0) {
                abort(422, 'هذه الفاتورة مكتملة الدفع بالفعل.');
            }

            if ((float)$request->amount > (float)$purchase->remaining) {
                abort(422, 'مبلغ الدفعة أكبر من المبلغ المتبقي على الفاتورة.');
            }

            $payment = SupplierPayment::create([
                'supplier_id'    => $request->supplier_id,
                'purchase_id'    => $request->purchase_id,
                'amount'         => $request->amount,
                'payment_date'   => $request->payment_date,
                'payment_method' => $request->payment_method,
                'notes'          => $request->notes,
            ]);

            $purchase->paid = (float)$purchase->paid + (float)$request->amount;
            $purchase->remaining = max((float)$purchase->total - (float)$purchase->paid, 0);
            $purchase->save();

            if (isset($supplier->balance)) {
                $supplier->balance = max((float)$supplier->balance - (float)$request->amount, 0);
                $supplier->save();
            }

            CashTransaction::create([
                'amount'         => $request->amount,
                'type'           => 'out',
                'reference_type' => 'supplier_payment',
                'reference_id'   => $payment->id,
                'description'    => 'دفعة للمورد ' . $supplier->name . ' على الفاتورة ' . $purchase->invoice_number,
                'date'           => $request->payment_date,
            ]);
        });

        return redirect()
            ->route('supplier.payments.receipt', $payment->id)
            ->with('success', 'تم تسجيل دفعة المورد بنجاح');
    }

    public function receipt(SupplierPayment $payment)
    {
        $payment->load(['supplier', 'purchase']);

        return view('supplier_payments.receipt', compact('payment'));
    }
}
