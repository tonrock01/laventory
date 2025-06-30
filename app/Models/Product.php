<?php

namespace App\Models;

use App\Filters\ProductFilter;
use App\Traits\CreatedUpdatedBy;
use App\Traits\HasVersioning;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    
    public function stockLogs(): HasMany
    {
        return $this->hasMany(StockLog::class, 'product_id', 'id');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return (new ProductFilter($filters))->apply($query);
    }
}
