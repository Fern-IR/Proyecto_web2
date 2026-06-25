<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Disponibilidad;
use App\Models\Operador;
use App\Models\PaqueteTuristico;
use App\Models\Pago;
use App\Models\Reserva;
use App\Models\Rol;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $rolOperador = Rol::where('nombre_rol', 'Operador')->first();

        if (! $rolOperador) {
            $this->command->warn('Ejecuta RolSeeder primero.');

            return;
        }

        $operador = Operador::firstOrCreate(
            ['nombre_comercial' => 'Bolivia Travel'],
            ['ciudad' => 'La Paz', 'estado' => 'activo']
        );

        Usuario::firstOrCreate(
            ['correo' => 'admin@boliviatravel.bo'],
            [
                'id_operador' => $operador->id_operador,
                'id_rol' => $rolOperador->id_rol,
                'password' => Hash::make('password'),
            ]
        );

        $paquetesData = [
            ['nombre' => 'Salar de Uyuni — Expedición 3 días', 'destino' => 'Uyuni', 'pais' => 'Bolivia', 'duracion' => 3, 'tipo' => 'Aventura', 'precio' => 1850, 'cupo' => 16, 'img' => config('travel.imagenes_destino.Uyuni'), 'desc' => 'Recorrido por el desierto de sal, lagunas altiplánicas y alojamiento en hotel de sal.'],
            ['nombre' => 'Lago Titicaca — Isla del Sol', 'destino' => 'Copacabana', 'pais' => 'Bolivia', 'duracion' => 2, 'tipo' => 'Cultural', 'precio' => 680, 'cupo' => 25, 'img' => config('travel.imagenes_destino.Copacabana'), 'desc' => 'Navegación al Lago Titicaca con visita a la Isla del Sol y cultura aymara.'],
            ['nombre' => 'Madidi — Selva Amazónica 5 días', 'destino' => 'Rurrenabaque', 'pais' => 'Bolivia', 'duracion' => 5, 'tipo' => 'Naturaleza', 'precio' => 2200, 'cupo' => 10, 'img' => config('travel.imagenes_destino.Rurrenabaque'), 'desc' => 'Expedición al Parque Nacional Madidi con avistamiento de fauna y lodge ecológico.'],
            ['nombre' => 'Cusco y Machu Picchu', 'destino' => 'Cusco', 'pais' => 'Perú', 'duracion' => 5, 'tipo' => 'Internacional', 'precio' => 3200, 'cupo' => 18, 'img' => config('travel.imagenes_destino.Cusco'), 'desc' => 'Paquete internacional con vuelo, traslados y visita guiada a Machu Picchu.'],
            ['nombre' => 'Torotoro — Cañones y Dinosaurios', 'destino' => 'Torotoro', 'pais' => 'Bolivia', 'duracion' => 3, 'tipo' => 'Aventura', 'precio' => 890, 'cupo' => 15, 'img' => config('travel.imagenes_destino.Torotoro'), 'desc' => 'Trekking por cañones, visita a vestigios paleontológicos y grutas.'],
            ['nombre' => 'Buenos Aires — Escapada urbana', 'destino' => 'Buenos Aires', 'pais' => 'Argentina', 'duracion' => 4, 'tipo' => 'Internacional', 'precio' => 2800, 'cupo' => 20, 'img' => config('travel.imagenes_destino.Buenos Aires'), 'desc' => 'City tour, tango show y barrios emblemáticos con hotel céntrico.'],
            ['nombre' => 'Samaipata y El Fuerte', 'destino' => 'Samaipata', 'pais' => 'Bolivia', 'duracion' => 2, 'tipo' => 'Cultural', 'precio' => 620, 'cupo' => 22, 'img' => config('travel.imagenes_destino.Samaipata'), 'desc' => 'Patrimonio arqueológico El Fuerte y paisajes del valle cruceño.'],
            ['nombre' => 'Río de Janeiro — Playas y Cristo', 'destino' => 'Río de Janeiro', 'pais' => 'Brasil', 'duracion' => 6, 'tipo' => 'Internacional', 'precio' => 4500, 'cupo' => 14, 'img' => config('travel.imagenes_destino.Río de Janeiro'), 'desc' => 'Corcovado, playas de Copacabana e Ipanema con guía en español.'],
            ['nombre' => 'La Paz — City Tour y Teleférico', 'destino' => 'La Paz', 'pais' => 'Bolivia', 'duracion' => 1, 'tipo' => 'Urbano', 'precio' => 280, 'cupo' => 30, 'img' => config('travel.imagenes_destino.La Paz'), 'desc' => 'Recorrido por la ciudad más alta del mundo con teleféricos y mercados.'],
            ['nombre' => 'Cartagena — Caribe colombiano', 'destino' => 'Cartagena', 'pais' => 'Colombia', 'duracion' => 5, 'tipo' => 'Internacional', 'precio' => 3600, 'cupo' => 16, 'img' => config('travel.imagenes_destino.Cartagena'), 'desc' => 'Ciudad amurallada, playas del Caribe y gastronomía costeña.'],
        ];

        $paquetes = [];
        foreach ($paquetesData as $data) {
            $paquetes[] = PaqueteTuristico::updateOrCreate(
                ['id_operador' => $operador->id_operador, 'nombre_paquete' => $data['nombre']],
                [
                    'destino' => $data['destino'],
                    'pais' => $data['pais'],
                    'duracion_dias' => $data['duracion'],
                    'descripcion' => $data['desc'],
                    'tipo_viaje' => $data['tipo'],
                    'imagen_url' => $data['img'],
                    'precio' => $data['precio'],
                    'cupo_maximo' => $data['cupo'],
                    'estado' => 'activo',
                ]
            );
        }

        $clientesData = [
            ['nombres' => 'María Fernández López', 'telefono' => '+591 71234567', 'correo' => 'maria.fernandez@gmail.com', 'nacionalidad' => 'Argentina'],
            ['nombres' => 'James Wilson', 'telefono' => '+1 555-0198', 'correo' => 'jwilson@outlook.com', 'nacionalidad' => 'Estados Unidos'],
            ['nombres' => 'Ana Paula Ribeiro', 'telefono' => '+55 1198765432', 'correo' => 'ana.ribeiro@uol.com.br', 'nacionalidad' => 'Brasil'],
            ['nombres' => 'Carlos Mendoza Quispe', 'telefono' => '+591 78901234', 'correo' => 'cmendoza@hotmail.com', 'nacionalidad' => 'Bolivia'],
            ['nombres' => 'Sophie Dubois', 'telefono' => '+33 612345678', 'correo' => 'sophie.d@gmail.com', 'nacionalidad' => 'Francia'],
            ['nombres' => 'Thomas Müller', 'telefono' => '+49 1701234567', 'correo' => 't.mueller@gmx.de', 'nacionalidad' => 'Alemania'],
            ['nombres' => 'Lucía García Martín', 'telefono' => '+34 612345678', 'correo' => 'lucia.garcia@gmail.com', 'nacionalidad' => 'España'],
            ['nombres' => 'Patricia Morales Vega', 'telefono' => '+591 72345678', 'correo' => 'pmorales@outlook.com', 'nacionalidad' => 'Bolivia'],
            ['nombres' => 'David O\'Connor', 'telefono' => '+353 871234567', 'correo' => 'doconnor@gmail.com', 'nacionalidad' => 'Irlanda'],
            ['nombres' => 'Yuki Tanaka', 'telefono' => '+81 9012345678', 'correo' => 'y.tanaka@yahoo.co.jp', 'nacionalidad' => 'Japón'],
        ];

        $clientes = [];
        foreach ($clientesData as $c) {
            $clientes[] = Cliente::firstOrCreate(
                ['id_operador' => $operador->id_operador, 'correo' => $c['correo']],
                array_merge($c, ['id_operador' => $operador->id_operador])
            );
        }

        $estadosReserva = ['pendiente', 'confirmada', 'confirmada', 'completada'];
        $metodosPago = ['Transferencia bancaria', 'QR / Billetera móvil', 'Tarjeta de crédito'];

        for ($i = 0; $i < 10; $i++) {
            $paquete = $paquetes[$i % count($paquetes)];
            $fecha = Carbon::now()->addDays(14 + ($i * 7));

            $disponibilidad = Disponibilidad::firstOrCreate(
                ['id_paquete' => $paquete->id_paquete, 'fecha' => $fecha->toDateString()],
                ['cupos_disponibles' => max(3, $paquete->cupo_maximo - rand(2, 6))]
            );

            $cliente = $clientes[$i];
            $estado = $estadosReserva[$i % count($estadosReserva)];

            $reserva = Reserva::firstOrCreate(
                ['id_cliente' => $cliente->id_cliente, 'id_disponibilidad' => $disponibilidad->id_disponibilidad],
                ['estado' => $estado, 'monto_total' => $paquete->precio]
            );

            if (! Pago::where('id_reserva', $reserva->id_reserva)->exists()) {
                Pago::create([
                    'id_reserva' => $reserva->id_reserva,
                    'metodo_pago' => $metodosPago[$i % count($metodosPago)],
                    'monto' => $estado === 'completada' ? $paquete->precio : round($paquete->precio * 0.5, 2),
                    'estado_pago' => $estado === 'pendiente' ? 'pendiente' : 'pagado',
                ]);
            }
        }

        $this->command->info('Datos demo creados (máx. 10 por entidad).');
        $this->command->info('Acceso: admin@boliviatravel.bo / password');
    }
}
