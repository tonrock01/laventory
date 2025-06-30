<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function index(array $filters = [])
    {
        $per_page = $filters['per_page'] ?? 10;
        return Category::filter($filters)->orderBy('id')->paginate($per_page);
    }

    public function store(array $category)
    {
        return $data = Category::create(['name' => $category['name']]);
    }
}
