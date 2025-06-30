<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockLog;

class StockLogService
{
    public function index(array $filters = [])
    {
        $per_page = $filters['per_page'] ?? 10;
        return StockLog::filter($filters)->with('product')->latest()->paginate($per_page);
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
        return StockLog::where('product_id', $product->id)->latest()->paginate($per_page);
    }
}
