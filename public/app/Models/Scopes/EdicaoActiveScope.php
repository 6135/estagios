<?php

namespace App\Models\Scopes;

use App\Models\EdicaoEstagio;
use Database\Seeders\CursosSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EdicaoActiveScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(EdicaoEstagio::ATIVO, true);
    }
}
