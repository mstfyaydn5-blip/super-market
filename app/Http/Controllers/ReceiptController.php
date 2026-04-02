<?php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $supplierPayments = SupplierPayment::with('supplier')
            ->get()
            ->map(function ($payment) {
                return [
                    'type' => 'دفعة مورد',
                    'party' => $payment->supplier->name ?? '-',
                    'amount' => (float) $payment->amount,
                    'date' => $payment->payment_date,
                    'reference' => 'SUP-' . $payment->id,
                    'route' => route('supplier.payments.receipt', $payment->id),
                    'created_at' => $payment->created_at,
                ];
            });

        $customerPayments = CustomerPayment::with('customer')
            ->get()
            ->map(function ($payment) {
                return [
                    'type' => 'دفعة عميل',
                    'party' => $payment->customer->name ?? '-',
                    'amount' => (float) $payment->amount,
                    'date' => $payment->payment_date,
                    'reference' => 'CUS-' . $payment->id,
                    'route' => route('customer.payments.receipt', $payment->id),
                    'created_at' => $payment->created_at,
                ];
            });

        $receipts = $supplierPayments
            ->concat($customerPayments)
            ->sortByDesc(fn ($item) => $item['date'] . ' ' . $item['created_at'])
            ->values();

        if ($request->filled('type')) {
            $receipts = $receipts->filter(function ($item) use ($request) {
                return $item['type'] === $request->type;
            })->values();
        }

        if ($request->filled('search')) {
            $search = mb_strtolower($request->search);

            $receipts = $receipts->filter(function ($item) use ($search) {
                return str_contains(mb_strtolower($item['party']), $search)
                    || str_contains(mb_strtolower($item['reference']), $search);
            })->values();
        }

        return view('receipts.index', compact('receipts'));
    }
}
