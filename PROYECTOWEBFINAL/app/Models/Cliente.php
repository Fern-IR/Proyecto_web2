<?php

namespace App\Models;

use App\Support\ScopesByOperador;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use ScopesByOperador;

    protected $table = 'clientes';

    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'id_operador',
        'nombres',
        'telefono',
        'correo',
        'nacionalidad',
    ];

    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_cliente', 'id_cliente');
    }
}
