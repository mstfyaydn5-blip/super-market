<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


public function index(Request $request)
{
    $q = Category::query()->withCount('products')->latest();


    if ($request->filled('search')) {
        $q->where('name', 'like', '%'.$request->search.'%');
    }

    $categories = $q->paginate(10)->withQueryString();

    return view('categories.index', compact('categories'));
}


    public function create()
    {
        return view('categories.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($data);

        return redirect()
            ->route('categories.index')
            ->with('success', '✅ تم إضافة الصنف بنجاح');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($data);

        return redirect()
            ->route('categories.index')
            ->with('success', '✏ تم تعديل الصنف بنجاح');
    }


    public function destroy(Category $category)
    {

        if ($category->products()->count() > 0) {
            return back()->with('error', '❌ لا يمكن حذف صنف مرتبط بمنتجات');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', '🗑 تم حذف الصنف');
    }

    public function show($id)
{
    $category = \App\Models\Category::with('products')->findOrFail($id);
    return view('categories.show', compact('category'));
}
}
