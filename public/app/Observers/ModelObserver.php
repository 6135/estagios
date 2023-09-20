<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ModelObserver extends Model
{
    use ModelObservableTrait;

    /**
     * Handle the User "created" event.
     */
    public static function created($object): void
    {
        if (session()->has('user'))
            $user = session()->get('user');

        Log::debug(get_class($object) . ' created: ' . $object->toJson() . ' by user: ' . ($user ?? 'unknown'));
    }

    /**
     * Handle the "updated" event.
     */
    public static function updated($object): void
    {
        if (session()->has('user'))
            $user = session()->get('user');

        Log::debug(get_class($object) . ' updated: ' . $object->toJson() . ' by user: ' . ($user ?? 'unknown'));
    }

    /**
     * Handle the "deleted" event.
     */
    public static function deleted($object): void
    {
        if (session()->has('user'))
            $user = session()->get('user');

        Log::debug(get_class($object) . ' deleted: ' . $object->toJson() . ' by user: ' . ($user ?? 'unknown'));
    }

    /**
     * Handle the "restored" event.
     */
    public static function restored($object): void
    {
        if (session()->has('user'))
            $user = session()->get('user');

        Log::debug(get_class($object) . ' restored: ' . $object->toJson() . ' by user: ' . ($user ?? 'unknown'));
    }

    /**
     * Handle the "forceDeleted" event.
     */
    public static function forceDeleted($object): void
    {
        if (session()->has('user'))
            $user = session()->get('user');

        Log::debug(get_class($object) . ' forceDeleted: ' . $object->toJson() . ' by user: ' . ($user ?? 'unknown'));
    }
}