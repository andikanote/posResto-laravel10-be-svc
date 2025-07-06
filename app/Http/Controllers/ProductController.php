<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Index
public function index()
    {
        $products = Product::with('category')
            ->when(request('status') !== null, function($query) {
                return $query->where('status', request('status'));
            })
            ->when(request('search'), function($query) {
                $search = request('search');
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhereHas('category', function($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%');
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.products.index', compact('products'));
    }

    // Create
    public function create()
    {
        $categories = Category::all();
        return view('pages.products.create', compact('categories'));
    }

    // Store
    public function store(Request $request)
        {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1|max:9999999999', // Max 10 digits
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->status = $request->has('status') ? 1 : 0;
        $product->is_favorite = $request->has('is_favorite') ? 1 : 0;

        $product->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $product->id . '.' . $extension;

            $image->storeAs('public/products/images', $imageName);
            $product->image = 'storage/products/images/' . $imageName;
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    // Update (Fixed Version)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1|max:9999999999', // Max 10 digits
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Update basic fields
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->status = $request->has('status') ? 1 : 0;
        $product->is_favorite = $request->has('is_favorite') ? 1 : 0;

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                $oldImagePath = str_replace('storage/', 'public/', $product->image);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = $product->id . '.' . $extension;

            // Store new image
            $path = $image->storeAs('public/products/images', $imageName);

            // Update image path in database
            $product->image = 'storage/products/images/' . $imageName;
        }

        $product->save();
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Destroy
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete associated image
        if ($product->image) {
            $imagePath = str_replace('storage/', 'public/', $product->image);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
