<?php

namespace App\Models;

use App\Filters\ProductFilter;
use App\Traits\CreatedUpdatedBy;
use App\Traits\HasVersioning;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use CreatedUpdatedBy, HasVersioning, LogsActivity;

    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'min_stock',
        'cost_price',
        'sale_price',
        'version'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'first_name', 'last_name');
    }
    
    public function stockLogs()
    {
        return $this->hasMany(StockLog::class, 'product_id', 'id');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return (new ProductFilter($filters))->apply($query);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Product')
            ->logOnly(['*'])
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
