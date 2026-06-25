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
            'paquetes' => PaqueteTuristico::forOperador($idOperador)->count(),
            'disponibilidades' => Disponibilidad::whereHas('paquete', fn ($q) => $q->where('id_operador', $idOperador))->count(),
            'reservas' => Reserva::whereHas('disponibilidad.paquete', fn ($q) => $q->where('id_operador', $idOperador))->count(),
        ];

        return view('dashboard', [
            'usuario' => Auth::user()->load(['operador', 'rol']),
            'stats' => $stats,
        ]);
    }
}
