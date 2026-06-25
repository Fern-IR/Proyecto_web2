<?php

namespace App\Models;

use App\Support\ScopesByOperador;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaqueteTuristico extends Model
{
    use ScopesByOperador;

    protected $table = 'paquetes_turisticos';

    protected $primaryKey = 'id_paquete';

    protected $fillable = [
        'id_operador',
        'nombre_paquete',
        'destino',
        'pais',
        'duracion_dias',
        'descripcion',
        'tipo_viaje',
        'imagen_url',
        'precio',
        'cupo_maximo',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
        ];
    }

    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
    }

    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'id_paquete', 'id_paquete');
    }
}
