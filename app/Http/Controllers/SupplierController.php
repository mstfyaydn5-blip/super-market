<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')
            ->with('success', 'تم إضافة المورد');
    }

    public function show(Supplier $supplier)
    {
        $payments = $supplier->payments()
            ->orderBy('payment_date', 'desc')
            ->get();

        $totalPayments = $payments->sum('amount');
        $totalPurchases = $supplier->purchaseInvoices()->sum('total');

        $currentBalance = (float) $supplier->opening_balance + (float) $totalPurchases - (float) $totalPayments;

        return view('suppliers.show', compact(
            'supplier',
            'payments',
            'totalPayments',
            'totalPurchases',
            'currentBalance'
        ));
    }

    public function statement(Request $request, Supplier $supplier)
    {
        $from = $request->from;
        $to   = $request->to;

        $purchaseQuery = $supplier->purchaseInvoices()->select(
            'id',
            'invoice_number',
            'invoice_date',
            'total',
            'paid',
            'remaining',
            'created_at'
        );

        $paymentQuery = $supplier->payments()->select(
            'id',
            'payment_date',
            'amount',
            'payment_method',
            'notes',
            'created_at'
        );

        if ($from) {
            $purchaseQuery->whereDate('invoice_date', '>=', $from);
            $paymentQuery->whereDate('payment_date', '>=', $from);
        }

        if ($to) {
            $purchaseQuery->whereDate('invoice_date', '<=', $to);
            $paymentQuery->whereDate('payment_date', '<=', $to);
        }

        $purchases = $purchaseQuery->get()->map(function ($invoice) {
            return [
                'date' => $invoice->invoice_date,
                'type' => 'فاتورة شراء',
                'reference' => $invoice->invoice_number,
                'details' => 'فاتورة شراء رقم ' . $invoice->invoice_number,
                'debit' => (float) $invoice->total,
                'credit' => 0,
                'sort_date' => $invoice->invoice_date,
                'created_at' => $invoice->created_at,
            ];
        });

        $payments = $paymentQuery->get()->map(function ($payment) {
            return [
                'date' => $payment->payment_date,
                'type' => 'دفعة',
                'reference' => 'PAY-' . $payment->id,
                'details' => 'دفعة للمورد' . ($payment->payment_method ? ' - ' . $payment->payment_method : ''),
                'debit' => 0,
                'credit' => (float) $payment->amount,
                'sort_date' => $payment->payment_date,
                'created_at' => $payment->created_at,
            ];
        });

        $rows = $purchases
            ->concat($payments)
            ->sortBy([
                ['sort_date', 'asc'],
                ['created_at', 'asc'],
            ])
            ->values();

        $runningBalance = (float) ($supplier->opening_balance ?? 0);

        $rows = $rows->map(function ($row) use (&$runningBalance) {
            $runningBalance += (float) $row['debit'];
            $runningBalance -= (float) $row['credit'];
            $row['running_balance'] = $runningBalance;
            return $row;
        });

        $totalDebit = $rows->sum('debit');
        $totalCredit = $rows->sum('credit');
        $currentBalance = $runningBalance;

        return view('suppliers.statement', compact(
            'supplier',
            'rows',
            'from',
            'to',
            'totalDebit',
            'totalCredit',
            'currentBalance'
        ));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')
            ->with('success', 'تم تحديث المورد');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'تم حذف المورد');
    }

    
}
