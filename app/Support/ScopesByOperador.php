<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait ScopesByOperador
{
    public function scopeForOperador(Builder $query, ?int $idOperador = null): Builder
    {
        $idOperador ??= Auth::user()?->id_operador;

        if ($idOperador === null) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where($this->getTable().'.id_operador', $idOperador);
    }
}
