<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre_rol' => 'Administrador', 'descripcion' => 'Acceso total al operador turístico'],
            ['nombre_rol' => 'Operador', 'descripcion' => 'Gestión diaria de paquetes, clientes y reservas'],
        ];

        foreach ($roles as $rol) {
            Rol::firstOrCreate(['nombre_rol' => $rol['nombre_rol']], $rol);
        }
    }
}
