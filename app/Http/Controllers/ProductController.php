<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
       $query = Product::with(['category','user','updatedBy']);




        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }


        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('name', 'like', "%{$q}%");
        }


          if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();





        return view('products.index', compact('products','categories'));
    }

    public function create()
{
    $categories = \App\Models\Category::orderBy('name')->get();
    return view('products.create', compact('categories'));
}


    public function store(Request $request)
    {


        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',


            'image'       => 'nullable|image|max:4096',


            'images'      => 'nullable|array',
            'images.*'    => 'image|max:4096',
        ]);


        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $data['user_id'] = auth()->id();
        $product = Product::create($data);

        $product->activities()->create([
            'user_id' => auth()->id(),
            'action'  => 'created',
            'details' => [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $product->quantity,
             ],
            ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'تمت إضافة المنتج');
    }

    public function show(Product $product)
    {
        $product->load(['category','images','user','updatedBy','activities.user']);
        return view('products.show', compact('product'));


    }

    public function edit(Request $request, Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load(['category','images','user']);



        $page = $request->query('page');
        $q = $request->query('q');
        $category_id = $request->query('category_id');

        return view('products.edit', compact('product','categories','page','q','category_id'));
    }

    public function update(Request $request, Product $product)
    {

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',

            'image'       => 'nullable|image|max:4096',

            'images'      => 'nullable|array',
            'images.*'    => 'image|max:4096',


            'page'        => 'nullable|integer',
            'q'           => 'nullable|string',
            'filter_category_id' => 'nullable|integer',
            'from'        => 'nullable|string',
        ]);


        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $old = $product->getOriginal();


        $data['updated_by'] = auth()->id();
        $product->update($data);

         $changes = $product->getChanges();

         $product->activities()->create([
          'user_id' => auth()->id(),
          'action'  => 'updated',
          'details' => [
          'old' => array_intersect_key($old, $changes),
          'new' => $changes,
          ],
          ]);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        if ($request->from === 'show') {
            return redirect()->route('products.show', $product)->with('success', 'تم التعديل');
        }

        return redirect()
            ->route('products.index', [
                'page' => $request->page,
                'q' => $request->q,
                'category_id' => $request->filter_category_id,
            ])
            ->with('success', 'تم التعديل');
    }

    public function destroy(Product $product)
    {


    $product->load('images');


    if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
    }

    foreach ($product->images as $img) {
        if ($img->path && Storage::disk('public')->exists($img->path)) {
            Storage::disk('public')->delete($img->path);
        }
    }
    $product->images()->delete();
     $product->activities()->create([
    'user_id' => auth()->id(),
    'action'  => 'deleted',
    'details' => [
    'name' => $product->name,
    ],
    ]);

    $product->delete();

    return back()->with('success', 'تم الحذف');
    }


    public function destroyImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) abort(404);

        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        return back()->with('success', 'تم حذف الصورة');
    }


    public function makeMainImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) abort(404);


        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }


        $product->update(['image' => $image->path]);

        return back()->with('success', 'تم تعيين الصورة الرئيسية');
    }

    public function myProducts(Request $request)
    {
    $query = Product::with(['category','user','updatedBy'])
    ->where('user_id', auth()->id())
    ->latest();


    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->filled('search')) {
        $query->where('name', 'like', '%'.$request->search.'%');
    }

    if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $products = $query->paginate(10)->withQueryString();
    $categories = Category::orderBy('name')->get();

    return view('products.mine', compact('products','categories'));
    }

}
