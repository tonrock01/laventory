<?php

namespace App\Services;

use App\Http\Resources\StockLogs\StocklogIndexResource;
use App\Models\Product;
use App\Models\StockLog;

class StockLogService
{
    public function index(array $filters = [])
    {
        $per_page = $filters['per_page'] ?? 10;
        $data = StockLog::filter($filters)->with(['product', 'user'])->latest()->paginate($per_page);

        return $data->setCollection(StocklogIndexResource::collection($data->items())->collection);
    }

    public function stockIn(array $request, Product $product)
    {
        $stock = $request['quantity'];
        $product->stock += $stock;
        $product->update();

        $data = StockLog::create([
            'product_id' => $request['product_id'],
            'action_type' => StockLog::STOCK_IN,
            'quantity' => $stock,
            'reason' => $request['reason'] ?? null
        ]);

        $data->min_stock = $product->min_stock;
        $data->stock = $product->stock;

        return $data;
    }

    public function stockOut(array $request, Product $product)
    {
        $stock = $request['quantity'];
        if ($product->stock < $stock) {
            throw new \Exception("Insufficient stock.");
        }

        $product->stock -= $stock;
        $product->update();

        $data = StockLog::create([
            'product_id' => $request['product_id'],
            'action_type' => StockLog::STOCK_OUT,
            'quantity' => $stock,
            'reason' => $request['reason'] ?? null
        ]);

        $data->min_stock = $product->min_stock;
        $data->stock = $product->stock;

        return $data;
    }

    public function productLogs(array $request, Product $product)
    {
        $per_page = $request['per_page'] ?? 10;
        $data = StockLog::with(['product', 'user'])->where('product_id', $product->id)->latest()->paginate($per_page);
        
        return $data->setCollection(StocklogIndexResource::collection($data->items())->collection);
    }
}
