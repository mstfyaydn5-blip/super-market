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
            ->with('success','تم إضافة المورد');
    }


   public function show(Supplier $supplier)
{

    $payments = $supplier->payments()
        ->orderBy('payment_date','desc')
        ->get();

    $totalPayments = $payments->sum('amount');

    $currentBalance = $supplier->opening_balance - $totalPayments;

    return view('suppliers.show',compact(
        'supplier',
        'payments',
        'totalPayments',
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
            ->with('success','تم تحديث المورد');
    }


    public function destroy(Supplier $supplier)
    {

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success','تم حذف المورد');

    }

}
