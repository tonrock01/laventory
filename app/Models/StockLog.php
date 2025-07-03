<?php

namespace App\Models;

use App\Filters\StockLogsFilter;
use App\Traits\CreatedUpdatedBy;
use App\Traits\HasVersioning;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StockLog extends Model
{
    use CreatedUpdatedBy, HasVersioning, LogsActivity;

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

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'first_name', 'last_name');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return (new StockLogsFilter($filters))->apply($query);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('StockLog')
            ->logOnly(['*'])
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
