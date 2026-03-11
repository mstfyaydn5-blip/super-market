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

return view('customer_payments.create',compact('customer'));

}



public function store(Request $request)
{

$request->validate([

'customer_id'=>'required',
'amount'=>'required|numeric',
'payment_date'=>'required'

]);

$payment = CustomerPayment::create($request->all());




CashTransaction::create([

'amount'=>$request->amount,

'type'=>'in',

'reference_type'=>'customer_payment',

'reference_id'=>$payment->id,

'description'=>'دفعة من العميل',

'date'=>$request->payment_date

]);



return redirect()
->route('customers.show',$request->customer_id)
->with('success','تم تسجيل الدفعة');

}

}
