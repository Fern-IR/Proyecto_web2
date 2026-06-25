<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Disponibilidad;
use App\Models\PaqueteTuristico;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $idOperador = Auth::user()->id_operador;

        $stats = [
            'clientes' => Cliente::forOperador($idOperador)->count(),
            'paquetes' => PaqueteTuristico::forOperador($idOperador)->where('estado', 'activo')->count(),
            'disponibilidades' => Disponibilidad::whereHas('paquete', fn ($q) => $q->where('id_operador', $idOperador))->count(),
            'reservas' => Reserva::whereHas('disponibilidad.paquete', fn ($q) => $q->where('id_operador', $idOperador))->count(),
            'destinos' => PaqueteTuristico::forOperador($idOperador)
                ->where('estado', 'activo')
                ->whereNotNull('destino')
                ->pluck('destino')
                ->unique()
                ->count(),
        ];

        $reservasRecientes = Reserva::query()
            ->whereHas('disponibilidad.paquete', fn ($q) => $q->where('id_operador', $idOperador))
            ->with(['cliente', 'disponibilidad.paquete'])
            ->latest('id_reserva')
            ->take(10)
            ->get();

        return view('dashboard', [
            'usuario' => Auth::user()->load(['operador', 'rol']),
            'stats' => $stats,
            'reservasRecientes' => $reservasRecientes,
        ]);
    }
}
