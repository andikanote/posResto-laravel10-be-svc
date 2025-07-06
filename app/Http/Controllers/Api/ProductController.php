<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Index API
    public function index()
    {
        try {
            $products = Product::with('category')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Products retrieved successfully',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Store API
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:1|max:9999999999',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'status' => 'sometimes|boolean',
                'is_favorite' => 'sometimes|boolean',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->category_id = $request->category_id;
            $product->status = $request->boolean('status', false);
            $product->is_favorite = $request->boolean('is_favorite', false);

            $product->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = 'PRD-' . $product->name . '-' . $product->id . '.' . $extension;

                $path = $image->storeAs('public/products/images', $imageName);

                if (!$path) {
                    throw new \Exception('Failed to store image');
                }

                $product->image = 'storage/products/images/' . $imageName;
                $product->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully',
                'data' => $product
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create product',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
