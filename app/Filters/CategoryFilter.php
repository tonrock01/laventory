<?php

namespace App\Filters;

class CategoryFilter extends QueryFilter
{
    public function search($keyword)
    {
        return $this->builder->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        });
    }
}
