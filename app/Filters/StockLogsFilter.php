<?php

namespace App\Filters;

use Carbon\Carbon;

class StockLogsFilter extends QueryFilter
{
    public function search($keyword)
    {
        return $this->builder->whereHas('product', function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        });
    }

    public function action_type($value)
    {
        return $this->builder->where('action_type', $value);
    }

    public function start_date($value)
    {
        if ($value) {
            $startDate = Carbon::parse($value)->format('Y-m-d');
            return $this->builder->whereDate('created_at', '>=', $startDate);
        }
    }

    public function end_date($value)
    {
        if ($value) {
            $endDate = Carbon::parse($value)->format('Y-m-d');
            return $this->builder->whereDate('created_at', '<=', $endDate);
        }
    }
}
