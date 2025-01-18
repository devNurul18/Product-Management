<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->search) {
            $query->where('product_id', 'like', "%{$request->search}%")
                ->orWhere('name', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%")
                ->orWhere('price', $request->search);
        }

        // Sorting functionality
        if ($request->sort_by && in_array($request->sort_by, ['name', 'price'])) {
            $query->orderBy($request->sort_by, $request->order ?? 'asc');
        }

        $products = $query->paginate(3);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|unique:products|max:255',
        'name' => 'required',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
    ]);

    $product = new Product();
    $product->product_id = $request->product_id;
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->stock = $request->stock;

    // Save the uploaded image and store its path
    if ($request->hasFile('image')) {
        $product->image = $request->file('image')->store('products', 'public');
    }

    $product->save();

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}

    public function show(Product $product)
    {
        return view ('products.show' , compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'product_id' => 'required|max:255|unique:products,product_id,' . $product->id,
        'name' => 'required',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Optional for updates
    ]);

    $product->product_id = $request->product_id;
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->stock = $request->stock;

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
            unlink(storage_path('app/public/' . $product->image));
        }

        // Save the new image
        $product->image = $request->file('image')->store('products', 'public');
    }

    $product->save();

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}


    public function destroy(Product $product)
    {
        Storage::delete($product->image);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
