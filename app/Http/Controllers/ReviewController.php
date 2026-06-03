<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return Review::with([
            'user',
            'libro'
        ])->get();
    }

    public function store(Request $request)
    {
        $review = new Review();

        $review->user_id = auth()->id();

        $review->libro_id = $request->libro_id;

        $review->rating = $request->rating;

        $review->comentario = $request->comentario;

        $ok = $review->save();

        if (!$ok) {
            return response()->json([
                'error' => true,
                'mensaje' => 'No se pudo crear la reseña'
            ], 500);
        }

        return response()->json([
            'error' => false,
            'mensaje' => 'Reseña creada correctamente',
            'data' => $review->load([
                'user',
                'libro'
            ])
        ], 201);
    }

    public function show(Review $review)
    {
        return response()->json([
            'error' => false,
            'data' => $review->load([
                'user',
                'libro'
            ])
        ]);
    }

    public function update(Request $request, Review $review)
    {
        if ($request->has('rating')) {
            $review->rating = $request->rating;
        }

        if ($request->has('comentario')) {
            $review->comentario = $request->comentario;
        }

        $review->save();

        return response()->json([
            'error' => false,
            'mensaje' => 'Reseña actualizada correctamente',
            'data' => $review->load([
                'user',
                'libro'
            ])
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json([
            'error' => false,
            'mensaje' => 'Reseña eliminada correctamente'
        ]);
    }
}
