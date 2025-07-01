<?php

namespace App\Services;

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
            $message = "🟢 <b>Stock In</b>\n"
                . "<b>Product :</b> <ins>{$data->product->name}</ins>\n"
                . "<b>Quantity :</b> <ins>{$data->quantity}</ins>\n"
                . "<b>Current Stock :</b> <ins>{$data->stock}</ins>";

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
            $message = "🔴 <b>Stock Out</b>\n"
                . "<b>Product :</b> <ins>{$data->product->name}</ins>\n"
                . "<b>Quantity :</b> <ins>{$data->quantity}</ins>\n"
                . "<b>Current Stock :</b> <ins>{$data->stock}</ins>";

            if ($data->stock <= $data->min_stock) {
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

    public function notiStockMin($data)
    {
        try {
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
