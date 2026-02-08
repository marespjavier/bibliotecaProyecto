<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLibroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        if (!$user) {
            return false;
        }

        // Admin o Bibliotecario con permiso
        return $user->hasRole('Admin') ||
            ($user->hasRole('Bibliotecario') && $user->hasPermissionTo('crear_libro'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'isbn' => 'required|string|size:13|unique:libros,isbn',
            'anyo_publicacion' => 'required|integer|min:1500|max:' . date('Y'),
            'descripcion' => 'nullable|string',
            'autor_id' => 'required|exists:autores,id',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }
}
