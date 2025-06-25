<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedUpdatedBy
{
    protected static function bootCreatedUpdatedBy()
    {
        // Listen to the 'created' event
        static::creating(function ($model) {

            // Automatically set created_by if not set
            if (Auth::check() && empty($model->created_by)) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        // Optionally, you can also listen to the 'updating' event
        static::updating(function ($model) {
            // Automatically set updated_by when updating
            // if (Auth::check() && !empty($model->updated_by)) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}
