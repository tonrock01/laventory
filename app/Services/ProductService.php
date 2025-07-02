<?php

namespace App\Services;

use App\Jobs\StockNotification;
use App\Models\Product;
use App\Models\StockLog;

class ProductService
{
    public function index(array $filters = [])
    {
        $per_page = $filters['per_page'] ?? 10;
        return Product::filter($filters)->latest()->paginate($per_page);
    }

    public function store(array $product)
    {
        $data = Product::create($product);
        
        $stock_log = StockLog::create([
            'product_id' => $data->id,
            'action_type' => StockLog::STOCK_IN,
            'quantity' => $data->stock,
            'reason' => 'Add new product'
        ]);

        if ($data && $stock_log) {
            StockNotification::dispatch($stock_log);
        }

        return $data;
    }

    public function findProduct($id)
    {
        return Product::findOrFail($id);
    }
}
