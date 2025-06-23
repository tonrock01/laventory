<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function index(array $filters = [])
    {
        $search = $filters['search'] ?? null;
        $per_page = $filters['per_page'] ?? 10;
        return Category::where('name', 'like', "%{$search}%")->orderBy('id')->paginate($per_page);
    }

    public function store(array $category)
    {
        return $data = Category::create(['name' => $category['name']]);
    }
}
