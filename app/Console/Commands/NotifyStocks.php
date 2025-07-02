<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class NotifyStocks extends Command
{
    protected $telegramService;

    public function __construct(TelegramService $telegramService)
    {
        parent::__construct();
        $this->telegramService = $telegramService;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify when products are almost out of stock.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->telegramService->notiStockMin();
    }
}
