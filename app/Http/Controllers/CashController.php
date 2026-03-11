<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;

class CashController extends Controller
{

    public function index()
    {

        $transactions = CashTransaction::latest()->paginate(15);

        $totalIn = CashTransaction::where('type','in')->sum('amount');

        $totalOut = CashTransaction::where('type','out')->sum('amount');

        $balance = $totalIn - $totalOut;

        return view('cash.index',compact(
            'transactions',
            'totalIn',
            'totalOut',
            'balance'
        ));

    }

}
