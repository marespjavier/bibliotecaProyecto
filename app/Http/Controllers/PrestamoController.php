<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadAllPrestamosRequest;
use App\Http\Requests\ShowPrestamoRequest;
use App\Http\Requests\StorePrestamoRequest;
use App\Http\Requests\UpdatePrestamoRequest;
use App\Http\Requests\DeletePrestamoRequest;
use App\Models\Prestamo;

class PrestamoController extends Controller
{
    public function index(ReadAllPrestamosRequest $request)
    {
        $user = auth()->user();

        if ($user->hasRole('Admin') || $user->hasRole('Bibliotecario')) {
            return Prestamo::with(['user', 'libro'])->get();
        }

        // Usuario normal -> solo los suyos
        return Prestamo::with(['user', 'libro'])
            ->where('user_id', $user->id)
            ->get();
    }


    public function store(StorePrestamoRequest $request)
    {
        $prestamo = new Prestamo();
        $prestamo->user_id = $request->user_id;
        $prestamo->libro_id = $request->libro_id;
        $prestamo->fecha_prestamo = $request->fecha_prestamo;
        $prestamo->fecha_devolucion = $request->fecha_devolucion;
        $prestamo->estado = $request->estado;

        $ok = $prestamo->save();

        if (!$ok) {
            return response()->json([
                'error' => true,
                'mensaje' => 'No se pudo crear el préstamo',
            ], 500);
        }

        return response()->json([
            'error' => false,
            'mensaje' => 'Préstamo creado correctamente',
            'data' => $prestamo->load(['user', 'libro']),
        ], 201);
    }

    public function show(ShowPrestamoRequest $request, Prestamo $prestamo)
    {
        return response()->json([
            'error' => false,
            'data' => $prestamo->load(['user', 'libro']),
        ], 200);
    }

    public function update(UpdatePrestamoRequest $request, Prestamo $prestamo)
    {
        if ($request->has('user_id')) $prestamo->user_id = $request->user_id;
        if ($request->has('libro_id')) $prestamo->libro_id = $request->libro_id;
        if ($request->has('fecha_prestamo')) $prestamo->fecha_prestamo = $request->fecha_prestamo;
        if ($request->has('fecha_devolucion')) $prestamo->fecha_devolucion = $request->fecha_devolucion;
        if ($request->has('estado')) $prestamo->estado = $request->estado;

        $ok = $prestamo->save();

        if (!$ok) {
            return response()->json([
                'error' => true,
                'mensaje' => 'No se pudo actualizar el préstamo',
            ], 500);
        }

        return response()->json([
            'error' => false,
            'mensaje' => 'Préstamo actualizado correctamente',
            'data' => $prestamo->load(['user', 'libro']),
        ], 200);
    }

    public function destroy(DeletePrestamoRequest $request, Prestamo $prestamo)
    {
        $ok = $prestamo->delete();

        if (!$ok) {
            return response()->json([
                'error' => true,
                'mensaje' => 'No se pudo borrar el préstamo',
            ], 500);
        }

        return response()->json([
            'error' => false,
            'mensaje' => 'Préstamo borrado correctamente',
        ], 200);
    }
}
