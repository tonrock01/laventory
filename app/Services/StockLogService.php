<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockLog;

class StockLogService
{
    public function index(array $filters = [])
    {
        $search = $filters['search'] ?? null;
        $per_page = $filters['per_page'] ?? 10;
        return StockLog::with('product')->whereHas('product', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->latest()->paginate($per_page);
    }

    public function stockIn(array $request, Product $product)
    {
        $stock = $request['quantity'];
        $product->stock += $stock;
        $product->update();

        return StockLog::create([
            'product_id' => $request['product_id'],
            'action_type' => StockLog::STOCK_IN,
            'quantity' => $stock,
            'reason' => $request['reason'] ?? null
        ]);
    }

    public function stockOut(array $request, Product $product)
    {
        $stock = $request['quantity'];
        if ($product->stock < $stock) {
            throw new \Exception("Insufficient stock.");
        }

        $product->stock -= $stock;
        $product->update();

        return StockLog::create([
            'product_id' => $request['product_id'],
            'action_type' => StockLog::STOCK_OUT,
            'quantity' => $stock,
            'reason' => $request['reason'] ?? null
        ]);
    }

    public function productLogs(array $request, Product $product)
    {
        $per_page = $request['per_page'] ?? null;
        return Product::with(['stockLogs' => function ($query) {
            $query->latest();
        }])->where('id', $product->id)->paginate($per_page);
    }
}
