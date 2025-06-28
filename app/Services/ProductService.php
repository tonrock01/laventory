<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function index(array $filters = [])
    {
        $search = $filters['search'] ?? null;
        $per_page = $filters['per_page'] ?? 10;
        return Product::where('name', 'like', "%{$search}%")->latest()->paginate($per_page);
    }

    public function store(array $product)
    {
        return $data = Product::create($product);
    }

    public function findProduct($id)
    {
        return Product::findOrFail($id);
    }
}
