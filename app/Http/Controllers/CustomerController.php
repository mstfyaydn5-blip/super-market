<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $customers->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $customers = $customers->latest()->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'تم إضافة العميل');
    }

    public function show(Customer $customer)
    {
        $payments = $customer->payments()
            ->orderBy('payment_date', 'desc')
            ->get();

        $totalPayments = $payments->sum('amount');
        $totalSales = method_exists($customer, 'sales') ? $customer->sales()->sum('total') : 0;

        $currentBalance = (float) ($customer->opening_balance ?? 0) + (float) $totalSales - (float) $totalPayments;

        return view('customers.show', compact(
            'customer',
            'payments',
            'totalPayments',
            'totalSales',
            'currentBalance'
        ));
    }

    public function statement(Request $request, Customer $customer)
    {
        $from = $request->from;
        $to   = $request->to;

        $salesQuery = method_exists($customer, 'sales')
            ? $customer->sales()->select(
                'id',
                'invoice_number',
                'sale_date',
                'total',
                'paid_amount',
                'remaining_amount',
                'created_at'
            )
            : collect();

        $paymentQuery = $customer->payments()->select(
            'id',
            'payment_date',
            'amount',
            'payment_method',
            'notes',
            'created_at'
        );

        if (!($salesQuery instanceof \Illuminate\Support\Collection)) {
            if ($from) {
                $salesQuery->whereDate('sale_date', '>=', $from);
            }

            if ($to) {
                $salesQuery->whereDate('sale_date', '<=', $to);
            }
        }

        if ($from) {
            $paymentQuery->whereDate('payment_date', '>=', $from);
        }

        if ($to) {
            $paymentQuery->whereDate('payment_date', '<=', $to);
        }

        $sales = collect();

        if (!($salesQuery instanceof \Illuminate\Support\Collection)) {
            $sales = $salesQuery->get()->map(function ($sale) {
                return [
                    'date' => $sale->sale_date,
                    'type' => 'فاتورة بيع',
                    'reference' => $sale->invoice_number ?? ('SAL-' . $sale->id),
                    'details' => 'فاتورة بيع رقم ' . ($sale->invoice_number ?? $sale->id),
                    'debit' => (float) $sale->total,
                    'credit' => 0,
                    'sort_date' => $sale->sale_date,
                    'created_at' => $sale->created_at,
                ];
            });
        }

        $payments = $paymentQuery->get()->map(function ($payment) {
            return [
                'date' => $payment->payment_date,
                'type' => 'دفعة',
                'reference' => 'PAY-' . $payment->id,
                'details' => 'دفعة من العميل' . ($payment->payment_method ? ' - ' . $payment->payment_method : ''),
                'debit' => 0,
                'credit' => (float) $payment->amount,
                'sort_date' => $payment->payment_date,
                'created_at' => $payment->created_at,
            ];
        });

        $rows = $sales
            ->concat($payments)
            ->sortBy([
                ['sort_date', 'asc'],
                ['created_at', 'asc'],
            ])
            ->values();

        $runningBalance = (float) ($customer->opening_balance ?? 0);

        $rows = $rows->map(function ($row) use (&$runningBalance) {
            $runningBalance += (float) $row['debit'];
            $runningBalance -= (float) $row['credit'];
            $row['running_balance'] = $runningBalance;
            return $row;
        });

        $totalDebit = $rows->sum('debit');
        $totalCredit = $rows->sum('credit');
        $currentBalance = $runningBalance;

        return view('customers.statement', compact(
            'customer',
            'rows',
            'from',
            'to',
            'totalDebit',
            'totalCredit',
            'currentBalance'
        ));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'تم تحديث العميل');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'تم حذف العميل');
    }
}
