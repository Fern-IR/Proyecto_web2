<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use App\Models\PaqueteTuristico;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {
        $paquetes = PaqueteTuristico::query()
            ->with('operador')
            ->where('estado', 'activo')
            ->latest('id_paquete')
            ->take(6)
            ->get();

        $destinos = PaqueteTuristico::query()
            ->where('estado', 'activo')
            ->whereNotNull('destino')
            ->select('destino', 'pais', DB::raw('MIN(imagen_url) as imagen_url'), DB::raw('MIN(precio) as precio_desde'), DB::raw('COUNT(*) as paquetes_count'))
            ->groupBy('destino', 'pais')
            ->orderByDesc('paquetes_count')
            ->take(6)
            ->get();

        $stats = [
            'operadores' => Operador::where('estado', 'activo')->count(),
            'paquetes' => PaqueteTuristico::where('estado', 'activo')->count(),
            'destinos' => PaqueteTuristico::where('estado', 'activo')->whereNotNull('destino')->pluck('destino')->unique()->count(),
        ];

        return view('landing', [
            'paquetes' => $paquetes,
            'destinos' => $destinos,
            'stats' => $stats,
            'beneficios' => config('travel.beneficios'),
            'testimonios' => config('travel.testimonios'),
        ]);
    }
}
