<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

public function index()
{
$customers = Customer::latest()->paginate(10);

return view('customers.index',compact('customers'));
}

public function create()
{
return view('customers.create');
}

public function store(Request $request)
{

$request->validate([
'name'=>'required'
]);

Customer::create($request->all());

return redirect()->route('customers.index')
->with('success','تم إضافة العميل');

}

public function show(Customer $customer)
{

$payments = $customer->payments;

$totalPayments = $payments->sum('amount');

$currentBalance = $customer->opening_balance + $totalPayments;

return view('customers.show',compact(
'customer',
'payments',
'totalPayments',
'currentBalance'
));

}

public function edit(Customer $customer)
{
return view('customers.edit',compact('customer'));
}

public function update(Request $request, Customer $customer)
{

$customer->update($request->all());

return redirect()->route('customers.index')
->with('success','تم تحديث العميل');

}

public function destroy(Customer $customer)
{

$customer->delete();

return redirect()->route('customers.index')
->with('success','تم حذف العميل');

}

}
