<?php

namespace App\Http\Controllers;

use App\Models\Libro;

use App\Models\Prestamo;

use App\Models\User;

class DashboardController extends Controller
{
    public function stats()
    {
        /*
        |--------------------------------------------------------------------------
        | Estadísticas generales
        |--------------------------------------------------------------------------
        */

        $totalLibros = Libro::count();

        $totalPrestamos = Prestamo::count();

        $prestamosActivos = Prestamo::where(
            'estado',
            'activo'
        )->count();

        $prestamosRetrasados = Prestamo::where(
            'estado',
            'retrasado'
        )->count();

        $usuarios = User::count();

        /*
        |--------------------------------------------------------------------------
        | Libros disponibles
        |--------------------------------------------------------------------------
        */

        $librosDisponibles = Libro::whereDoesntHave(
            'prestamos',
            function ($query) {

                $query->whereIn('estado', [
                    'activo',
                    'retrasado'
                ]);
            }
        )->count();

        return response()->json([

            'error' => false,

            'data' => [

                'totalLibros' =>
                    $totalLibros,

                'totalPrestamos' =>
                    $totalPrestamos,

                'prestamosActivos' =>
                    $prestamosActivos,

                'prestamosRetrasados' =>
                    $prestamosRetrasados,

                'usuarios' =>
                    $usuarios,

                'librosDisponibles' =>
                    $librosDisponibles,
            ]

        ], 200);
    }
}
