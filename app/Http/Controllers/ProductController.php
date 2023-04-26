<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $products = Product::where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('description', 'LIKE', '%' . $search . '%')
                      ->paginate(10);
                      $categories = Category::all();
        return view('product.index',compact('products','categories'));
    }

    public function diplayproductlist(Request $request)
    {
        $categoryId = $request->query('category_id');
        $query = Product::query();
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $products = $query->paginate(10);
        $categories = Category::all();
        return view('products.diplayproductlist', compact('products', 'categories','categoryId'));
    }

    public function create()
    {
        return view('product.create', compact('categories'));
    }
    public function store(Request $request)
    {
         
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
         
        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->storeAs('public/images', $imageName);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->image = $imageName;
        $product->save();

        return redirect()->back()->with('success', 'Porduct created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return response()->json(['success' => true, 'data' => $product]);
        //return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $productId = $request->input('product_id');
        $product = Product::find($productId);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($request->hasFile('image')) {
            Storage::delete('public/images/' . $product->image);

            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->storeAs('public/images', $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('product.index')
            ->with('success','Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete('public/images/' . $product->image);
        $product->delete();

        return redirect()->route('product.index')
            ->with('success','Product deleted successfully.');
    }
}

