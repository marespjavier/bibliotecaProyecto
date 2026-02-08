<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadAllLibrosRequest;
use App\Http\Requests\StoreLibroRequest;
use App\Http\Requests\UpdateLibroRequest;
use App\Http\Requests\ShowLibroRequest;
use App\Http\Requests\DeleteLibroRequest;
use App\Models\Libro;

class LibroController extends Controller
{
    public function index(ReadAllLibrosRequest $request)
    {
        return Libro::with(['autor','categoria'])->get();
    }

    public function store(StoreLibroRequest $request)
    {
        $libro = new Libro();
        $libro->titulo = $request->titulo;
        $libro->isbn = $request->isbn;
        $libro->anyo_publicacion = $request->anyo_publicacion;
        $libro->descripcion = $request->descripcion;
        $libro->autor_id = $request->autor_id;
        $libro->categoria_id = $request->categoria_id;

        $ok = $libro->save();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo crear el libro',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Libro creado correctamente',
            'data' => $libro->load(['autor','categoria']),
        ], 201);
    }

    public function update(UpdateLibroRequest $request, Libro $libro)
    {
        if ($request->titulo !== null) $libro->titulo = $request->titulo;
        if ($request->isbn !== null) $libro->isbn = $request->isbn;
        if ($request->anyo_publicacion !== null) $libro->anyo_publicacion = $request->anyo_publicacion;
        if ($request->descripcion !== null) $libro->descripcion = $request->descripcion;
        if ($request->autor_id !== null) $libro->autor_id = $request->autor_id;
        if ($request->categoria_id !== null) $libro->categoria_id = $request->categoria_id;

        $ok = $libro->save();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo actualizar el libro',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Libro actualizado correctamente',
            'data' => $libro->load(['autor','categoria']),
        ], 200);
    }

    public function show(ShowLibroRequest $request, Libro $libro)
    {
        return response([
            'error' => false,
            'data' => $libro->load(['autor', 'categoria']),
        ], 200);
    }

    public function destroy(DeleteLibroRequest $request, Libro $libro)
    {
        $ok = $libro->delete();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo borrar el libro',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Libro borrado correctamente',
        ], 200);
    }
}
