<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disponibilidad extends Model
{
    protected $table = 'disponibilidad';

    protected $primaryKey = 'id_disponibilidad';

    protected $fillable = [
        'id_paquete',
        'fecha',
        'cupos_disponibles',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    public function paquete(): BelongsTo
    {
        return $this->belongsTo(PaqueteTuristico::class, 'id_paquete', 'id_paquete');
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_disponibilidad', 'id_disponibilidad');
    }
}
