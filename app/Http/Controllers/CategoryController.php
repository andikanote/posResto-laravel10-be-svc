<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Assuming you have a Category model
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //Index
    public function index()
    {
        $categories = Category::Paginate(10); // Assuming you have a Category model
        return view('pages.categories.index', compact('categories'));
    }

    //Create
    public function create()
    {
        return view('pages.categories.create');
    }

    //Edit
    public function edit($id)
    {
        $category = Category::findOrFail($id); // Assuming you have a Category model
        return view('pages.categories.edit', compact('category'));
    }

    //Show
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.show', compact('category'));
    }

    //Destroy
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete associated image
        if ($category->image) {
            $imagePath = str_replace('storage/', 'public/', $category->image);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    //Store
    public function store(Request $request)
    {
        // Logic to store a new category
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        //Store the request data into the database
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = 'CAT-' . $category->name . '-' . $category->id . '.' . $extension;

            $image->storeAs('public/categories/images', $imageName);
            $category->image = 'storage/categories/images/' . $imageName;
            $category->save();
        }
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    //Update
    public function update(Request $request, $id)
    {
        // Logic to update an existing category
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        //Update the request data into the database
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($category->image) {
                $oldImagePath = str_replace('storage/', 'public/', $category->image);
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = 'CAT-' . $category->name . '-' . $category->id . '.' . $extension;

            // Store the new image
            $path = $image->storeAs('public/categories/images', $imageName);
            // Update the image path in the database
            $category->image = 'storage/categories/images/' . $imageName;
        }
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
}
