<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function create($data)
    {
        return Category::create([
            'name' => $data['name'],
        ]);
    }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $category;
    }
}
