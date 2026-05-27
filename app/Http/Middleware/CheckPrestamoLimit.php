<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Prestamo;

class CheckPrestamoLimit
{
    /**
     * Límite préstamos activos usuario
     */

    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $userId = $request->user_id;

        if ($userId) {

            /*
            |--------------------------------------------------------------------------
            | Contar préstamos NO devueltos
            |--------------------------------------------------------------------------
            */

            $prestamosActivos = Prestamo::where(
                'user_id',
                $userId
            )
                ->whereIn('estado', [
                    'activo',
                    'retrasado'
                ])
                ->count();

            /*
            |--------------------------------------------------------------------------
            | Máximo permitido
            |--------------------------------------------------------------------------
            */

            if ($prestamosActivos >= 3) {

                return response()->json([
                    'error' => true,

                    'message' =>
                        'Este usuario ya tiene el límite máximo de préstamos activos'
                ], 403);
            }
        }

        return $next($request);
    }
}
