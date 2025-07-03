<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return (new CategoryFilter($filters))->apply($query);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Category')
            ->logOnly(['*'])
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }
}
