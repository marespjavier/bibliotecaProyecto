<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\User;
use App\Models\Review;

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

        /*
        |--------------------------------------------------------------------------
        | Reviews
        |--------------------------------------------------------------------------
        */

        $totalReviews = Review::count();

        $ratingMedia = round(
            Review::avg('rating') ?? 0,
            2
        );

        $usuariosConReviews = Review::distinct('user_id')
            ->count('user_id');

        /*
        |--------------------------------------------------------------------------
        | Libro mejor valorado
        |--------------------------------------------------------------------------
        */

        $bestBookReview = Review::selectRaw(
            'libro_id, AVG(rating) as media'
        )
            ->groupBy('libro_id')
            ->orderByDesc('media')
            ->first();

        $bestBook = null;

        if ($bestBookReview) {

            $libro = Libro::find(
                $bestBookReview->libro_id
            );

            if ($libro) {

                $bestBook = [
                    'titulo' => $libro->titulo,
                    'rating' => round(
                        $bestBookReview->media,
                        2
                    ),
                ];
            }
        }

        /*
|--------------------------------------------------------------------------
| Top libros mejor valorados
|--------------------------------------------------------------------------
*/

        $topBooks = Review::selectRaw('
    libro_id,
    AVG(rating) as media,
    COUNT(*) as total_reviews
')
            ->with('libro')
            ->groupBy('libro_id')
            ->havingRaw('COUNT(*) >= 2')
            ->orderByDesc('media')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top usuarios con más reseñas
        |--------------------------------------------------------------------------
        */

        $topUsers = Review::selectRaw('
    user_id,
    COUNT(*) as total_reviews
')
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('total_reviews')
            ->limit(5)
            ->get();

        return response()->json([

            'error' => false,

            'data' => [

                'totalLibros' => $totalLibros,

                'totalPrestamos' => $totalPrestamos,

                'prestamosActivos' => $prestamosActivos,

                'prestamosRetrasados' => $prestamosRetrasados,

                'usuarios' => $usuarios,

                'librosDisponibles' => $librosDisponibles,

                /*
                |--------------------------------------------------------------------------
                | Reviews
                |--------------------------------------------------------------------------
                */

                'totalReviews' => $totalReviews,

                'ratingMedia' => $ratingMedia,

                'usuariosConReviews' => $usuariosConReviews,

                'bestBook' => $bestBook,

                'topBooks' => $topBooks,

                'topUsers' => $topUsers,
            ]

        ], 200);
    }
}
