<?php

namespace App\Http\Controllers\Api;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController
{

    /**
     *  Todas as categorias
     */
    public function index()
    {
        $categories = Category::all();

        if (!$categories) {
            return response()->json([
                'error' => 404,
                'message' => 'Categories not found.'
            ], 404);
        }

        return $categories;
    }
    /**
     * Cria uma categoria
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required'],
            'code' => ['required'],
            'description' => ['required'],
            'image' => ['sometimes', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validate['image'] = $request->file('image')->store('categories', 'public');
        }

        $validate['active'] = false;

        return Category::create($validate);
    }
    /**
     * Detalhes de uma categoria
     */
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
    /**
     * Atualiza  uma categoria
     */
    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => ['sometimes', 'required'],
            'code' => ['sometimes', 'required'],
            'description' => ['sometimes', 'required'],
            'image' => ['sometimes', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validate['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validate);

        return response()->json($category);
    }
    /**
     * Desativa/ativa categoria
     */
    public function destroy(Category $category)
    {
        if (!$category) {
            return response()->json([
                'error' => 404,
                'message' => 'Categories not found.'
            ], 404);
        }

        $isActive = $category->active;

        $category->updateOrFail(['active' => !$isActive]);

        return response()->json($category);
    }
}
