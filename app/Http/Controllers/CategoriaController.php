<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadAllCategoriasRequest;
use App\Http\Requests\ShowCategoriaRequest;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Http\Requests\DeleteCategoriaRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // LISTAR categorías
    public function index(ReadAllCategoriasRequest $request)
    {
        return Categoria::all();
    }

    // MOSTRAR una categoría
    public function show(ShowCategoriaRequest $request, Categoria $categoria)
    {
        return response([
            'error' => false,
            'data' => $categoria
        ], 200);
    }

    // CREAR categoría
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;

        $ok = $categoria->save();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo crear la categoría',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Categoría creada correctamente',
            'data' => $categoria
        ], 201);
    }

    // ACTUALIZAR categoría
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        if ($request->has('nombre')) {
            $categoria->nombre = $request->nombre;
        }

        if ($request->has('descripcion')) {
            $categoria->descripcion = $request->descripcion;
        }

        $ok = $categoria->save();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo actualizar la categoría',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Categoría actualizada correctamente',
            'data' => $categoria
        ], 200);
    }

    // BORRAR categoría
    public function destroy(DeleteCategoriaRequest $request, Categoria $categoria)
    {
        $ok = $categoria->delete();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo borrar la categoría',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Categoría borrada correctamente',
        ], 200);
    }
}
