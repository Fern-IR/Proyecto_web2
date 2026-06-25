<?php

namespace App\Http\Controllers;

use App\Models\PaqueteTuristico;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {
        $paquetes = PaqueteTuristico::query()
            ->with('operador')
            ->latest('id_paquete')
            ->take(6)
            ->get();

        return view('landing', compact('paquetes'));
    }
}
