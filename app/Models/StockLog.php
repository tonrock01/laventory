<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use App\Traits\HasVersioning;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLog extends Model
{
    use CreatedUpdatedBy, HasVersioning;

    public const STOCK_IN = 1;
    public const STOCK_OUT = 2;

    protected $fillable = [
        'name',
        'product_id',
        'action_type',
        'quantity',
        'reason',
        'version'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
