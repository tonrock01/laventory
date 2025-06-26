<?php

namespace App\Traits;

trait HasVersioning
{
    public static function bootHasVersioning(): void
    {
        static::saving(function ($model) {
            if (!isset($model->version)) {
                $model->version = 1;
            } elseif ($model->isDirty()) {
                $model->version += 1;
            }
        });
    }
}
