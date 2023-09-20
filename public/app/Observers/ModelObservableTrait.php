<?php

namespace App\Observers;

use App\Observers\ModelObserver;

trait ModelObservableTrait
{
    public static function bootModelObservableTrait()
    {
        static::observe(new ModelObserver);
    }
}