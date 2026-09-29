<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    private function getAllCategories()
    {
        return Category::paginate(min(max((int) request()->cookie('per_page', 10), 1), 100));
    }
    private function fieldsLabel()
    {
        return [
            'id' => ['label' => 'ID', 'show_on_table' => false],
            'image' => ['label' => 'Image', 'component' => 'table.image', 'show_on_table' => true],
            'name' => ['label' => 'Name', 'show_on_table' => false],
            'code' => ['label' => 'Code', 'show_on_table' => true],
            'description' => ['label' => 'Description', 'show_on_table' => true],
            'active' => ['label' => 'Active', 'component' => 'switch', 'show_on_table' => true],
            'created_at' => ['label' => 'Created at', 'show_on_table' => true],
            'updated_at' => ['label' => 'Updated at', 'show_on_table' => true],
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $header = self::fieldsLabel();
        $categories = self::getAllCategories();
        return view('categories.index', ['header' => $header, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
