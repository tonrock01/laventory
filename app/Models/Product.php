<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use App\Traits\HasVersioning;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use CreatedUpdatedBy, HasVersioning;

    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'min_stock',
        'cost_price',
        'sale_price',
        'version'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
