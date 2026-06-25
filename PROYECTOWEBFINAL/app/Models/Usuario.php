<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'id_operador',
        'id_rol',
        'correo',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function operador(): BelongsTo
    {
        return $this->belongsTo(Operador::class, 'id_operador', 'id_operador');
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function getAuthIdentifierName(): string
    {
        return 'id_usuario';
    }

    public function getEmailForPasswordReset(): string
    {
        return $this->correo;
    }

    public function getNameAttribute(): string
    {
        return $this->operador?->nombre_comercial ?? $this->correo;
    }

    public function getEmailAttribute(): string
    {
        return $this->correo;
    }
}
