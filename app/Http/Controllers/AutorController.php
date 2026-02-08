<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteAutorRequest;
use App\Http\Requests\ReadAllAutoresRequest;
use App\Http\Requests\ShowAutorRequest;
use App\Http\Requests\StoreAutorRequest;
use App\Http\Requests\UpdateAutorRequest;
use App\Models\Autor;

class AutorController extends Controller
{
    public function index(ReadAllAutoresRequest $request)
    {
        // Estilo tutor: devolver directamente
        return Autor::all();
    }

    public function show(ShowAutorRequest $request, Autor $autor)
    {
        return response([
            'error' => false,
            'data' => $autor
        ], 200);
    }

    public function store(StoreAutorRequest $request)
    {
        $autor = new Autor();
        $autor->nombre = $request->nombre;
        $autor->apellido = $request->apellido; // nullable
        $autor->fecha_nacimiento = $request->fecha_nacimiento; // nullable
        $autor->nacionalidad = $request->nacionalidad; // nullable

        $ok = $autor->save();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo crear el autor',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Autor creado correctamente',
            'data' => $autor
        ], 201);
    }

    public function update(UpdateAutorRequest $request, Autor $autor)
    {
        if ($request->has('nombre')) $autor->nombre = $request->nombre;
        if ($request->has('apellido')) $autor->apellido = $request->apellido;
        if ($request->has('fecha_nacimiento')) $autor->fecha_nacimiento = $request->fecha_nacimiento;
        if ($request->has('nacionalidad')) $autor->nacionalidad = $request->nacionalidad;

        $ok = $autor->save();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo actualizar el autor',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Autor actualizado correctamente',
            'data' => $autor
        ], 200);
    }

    public function destroy(DeleteAutorRequest $request, Autor $autor)
    {
        // (Opcional negocio) Si tiene libros, no permitir borrar
        if ($autor->libros()->exists()) {
            return response([
                'error' => true,
                'message' => 'No se puede borrar el autor porque tiene libros asociados',
            ], 409);
        }

        $ok = $autor->delete();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo borrar el autor',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Autor borrado correctamente',
        ], 200);
    }
}

