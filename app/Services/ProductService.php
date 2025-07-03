<?php

namespace App\Services;

use App\Http\Resources\Product\ProductResource;
use App\Jobs\StockNotification;
use App\Models\Product;
use App\Models\StockLog;

class ProductService
{
    public function index(array $filters = [])
    {
        $per_page = $filters['per_page'] ?? 10;
        $data = Product::filter($filters)->with('user')->latest()->paginate($per_page);
        return $data->setCollection(ProductResource::collection($data->items())->collection);
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

    public function show(Product $product)
    {
        $data = $product->load('user');

        return new ProductResource($data);
    }

    public function findProduct($id)
    {
        return Product::findOrFail($id);
    }
}
