<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\CashTransaction;
use Illuminate\Http\Request;

class CustomerPaymentController extends Controller
{
    public function create($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);

        return view('customer_payments.create', compact('customer'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $payment = CustomerPayment::create([
            'customer_id' => $request->customer_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
        ]);

        CashTransaction::create([
            'amount' => $request->amount,
            'type' => 'in',
            'reference_type' => 'customer_payment',
            'reference_id' => $payment->id,
            'description' => 'دفعة من العميل',
            'date' => $request->payment_date,
        ]);

        return redirect()
            ->route('customer.payments.receipt', $payment->id)
            ->with('success', 'تم تسجيل دفعة العميل بنجاح');
    }

    public function receipt(CustomerPayment $payment)
    {
        $payment->load('customer');

        return view('customer_payments.receipt', compact('payment'));
    }
}
