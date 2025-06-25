<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use CreatedUpdatedBy;

    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'min_stock',
        'cost_price',
        'sale_price'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
