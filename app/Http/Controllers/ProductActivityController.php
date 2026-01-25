<?php

namespace App\Http\Controllers;

use App\Models\ProductActivity;
use App\Models\User;
use Illuminate\Http\Request;

class ProductActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductActivity::with(['user', 'product']);

        if ($request->filled('q')) {
         $q = $request->q;
         $query->whereHas('product', function ($qq) use ($q) {
         $qq->where('name', 'like', "%{$q}%");
        });
        }
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }


        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $activities = $query->latest()->paginate(20)->withQueryString();

        $users = User::orderBy('name')->get();

        $actions = [
            'created' => 'إضافة منتج',
            'updated' => 'تعديل منتج',
            'deleted' => 'حذف منتج',
            'image_added' => 'إضافة صورة',
            'image_deleted' => 'حذف صورة',
            'main_image_changed' => 'تغيير الصورة الرئيسية',
        ];

        return view('activities.index', compact('activities', 'users', 'actions'));



    }


}
