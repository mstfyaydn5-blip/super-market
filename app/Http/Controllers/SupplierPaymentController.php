<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\CashTransaction;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{

    public function create($supplier_id)
    {
        $supplier = Supplier::findOrFail($supplier_id);

        return view('supplier_payments.create', compact('supplier'));
    }



    public function store(Request $request)
    {

        $request->validate([
            'supplier_id' => 'required',
            'amount' => 'required|numeric',
            'payment_date' => 'required'
        ]);



        $payment = SupplierPayment::create($request->all());


      
        CashTransaction::create([

            'amount' => $request->amount,

            'type' => 'out',

            'reference_type' => 'supplier_payment',

            'reference_id' => $payment->id,

            'description' => 'دفعة للمورد',

            'date' => $request->payment_date

        ]);


        return redirect()
            ->route('suppliers.show', $request->supplier_id)
            ->with('success', 'تم تسجيل الدفعة وخصمها من الصندوق');

    }

}
