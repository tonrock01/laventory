<?php

namespace App\Models;

use App\Filters\CategoryFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return (new CategoryFilter($filters))->apply($query);
    }
}
