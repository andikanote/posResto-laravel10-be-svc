<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //Index API
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Categories retrieved successfully',
                'data' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Store API
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $imageName = 'CAT-' . $category->name . '-' . $category->id . '.' . $extension;

                // Store in public storage with proper path
                $path = $image->storeAs('public/categories/images', $imageName);

                // Save the web-accessible path
                $category->image = 'storage/categories/images/' . $imageName;
                $category->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => $category,
                'image' => $category->image
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
