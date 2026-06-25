<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operador extends Model
{
    protected $table = 'operadores';

    protected $primaryKey = 'id_operador';

    protected $fillable = [
        'nombre_comercial',
        'ciudad',
        'estado',
    ];

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'id_operador', 'id_operador');
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class, 'id_operador', 'id_operador');
    }

    public function paquetesTuristicos(): HasMany
    {
        return $this->hasMany(PaqueteTuristico::class, 'id_operador', 'id_operador');
    }
}
