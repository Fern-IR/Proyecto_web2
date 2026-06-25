<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Operador;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_comercial' => ['required', 'string', 'max:150'],
            'ciudad' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:usuarios,correo'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $usuario = DB::transaction(function () use ($request) {
                $operador = Operador::create([
                    'nombre_comercial' => $request->nombre_comercial,
                    'ciudad' => $request->ciudad,
                    'estado' => 'activo',
                ]);

                $rol = Rol::where('nombre_rol', 'Operador')->firstOrFail();

                return Usuario::create([
                    'id_operador' => $operador->id_operador,
                    'id_rol' => $rol->id_rol,
                    'correo' => $request->correo,
                    'password' => Hash::make($request->password),
                ]);
            });
        } catch (QueryException $exception) {
            Log::error('Error al registrar usuario', [
                'correo' => $request->correo,
                'message' => $exception->getMessage(),
            ]);

            throw ValidationException::withMessages([
                'registro' => 'No fue posible completar el registro. Verifica la conexión a la base de datos e inténtalo de nuevo.',
            ]);
        }

        event(new Registered($usuario));

        Auth::login($usuario);

        return redirect(route('dashboard', absolute: false));
    }
}
