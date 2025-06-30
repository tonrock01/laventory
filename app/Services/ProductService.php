<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function index(array $filters = [])
    {
        $per_page = $filters['per_page'] ?? 10;
        return Product::filter($filters)->latest()->paginate($per_page);
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
