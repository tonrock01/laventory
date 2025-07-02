<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class TelegramService extends Api
{
    protected string $group_id;

    public function __construct()
    {
        parent::__construct(env('TELEGRAM_BOT_TOKEN'));
        $this->group_id = env('TELEGRAM_GROUP_ID');
    }

    public function notiStockIn($data)
    {
        try {
            $product = Product::findOrFail($data->product_id);

            if ($product->version === 1) {
                $header = "🆕 <b>Add New Product</b>";
            } else {
                $header = "🟢 <b>Stock In</b>";
            }

            $message = "{$header}\n"
                . "\n"
                . "<b>Product :</b> <ins>{$product->name}</ins>\n"
                . "<b>Quantity :</b> <ins>{$data->quantity}</ins>\n"
                . "<b>Current Stock :</b> <ins>{$product->stock}</ins>";

            $this->sendMessage([
                'chat_id' => $this->group_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function notiStockOut($data)
    {
        try {
            $product = Product::find($data->product_id);

            $message = "🔴 <b>Stock Out</b>\n"
                . "\n"
                . "<b>Product :</b> <ins>{$product->name}</ins>\n"
                . "<b>Quantity :</b> <ins>{$data->quantity}</ins>\n"
                . "<b>Current Stock :</b> <ins>{$product->stock}</ins>";

            if ($product->stock <= $product->min_stock) {
                $message = "{$message}\n"
                    . "\n"
                    . "⚠️ <b>This product is almost out of stock. Please restock.</b>";
            }

            $this->sendMessage([
                'chat_id' => $this->group_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function notiStockMin()
    {
        try {
            $products = Product::whereColumn('stock', '<=', 'min_stock')->get();

            $header = "⚠️ <b>List of products almost out of stock</b>";
            $message = "";

            foreach ($products as $product) {
                $message = "{$message}\n"
                    . "<b>Product :</b> <ins>{$product->name}</ins>\n"
                    . "<b>Current Stock :</b> <ins>{$product->stock}</ins>";
            }

            $message = "{$header}\n"
                . "{$message}\n"
                . "\n"
                . "⚠️ <b>Please restock.</b>";

            $this->sendMessage([
                'chat_id' => $this->group_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
