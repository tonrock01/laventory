<?php

namespace App\Jobs;

use App\Models\StockLog;
use App\Services\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StockNotification implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(TelegramService $telegramService): void
    {
        if ($this->data->action_type == StockLog::STOCK_OUT) {
            $telegramService->notiStockOut($this->data);
        } else {
            $telegramService->notiStockIn($this->data);
        }
    }
}
