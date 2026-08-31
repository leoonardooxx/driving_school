<?php

namespace App\Http\Controllers\Api;


use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController
{

    public function index()
    {
        $categories = Category::all();

         if (!$categories) {
            return response()->json([
                'error' => 404,
                'message' => 'Categories not found.'
            ], 404);
        }
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'description' => ['required'],
            'state' => ['nullable', 'boolean'],
        ]);

        return Category::create($validate);
    }


    public function show(int $category)
    {
        $category = Category::find($category);

        if (!$category) {
            return response()->json([
                'error' => 404,
                'message' => 'Category not found.'
            ], 404);
        }

        return response()->json($category);
    }


    public function update(Request $request, Category $category)
    {
        //
    }


    public function destroy(Category $category)
    {
        //
    }
}
