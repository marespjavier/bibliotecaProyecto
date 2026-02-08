<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLibroRequest extends FormRequest
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

        return $user->hasRole('Admin') ||
            ($user->hasRole('Bibliotecario') && $user->hasPermissionTo('editar_libro'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $libroId = $this->route('libro')->id;

        return [
            'titulo' => 'sometimes|string|max:255',
            'isbn' => [
                'sometimes',
                'string',
                'size:13',
                Rule::unique('libros', 'isbn')->ignore($libroId),
            ],
            'anyo_publicacion' => 'sometimes|integer|min:1500|max:' . date('Y'),
            'descripcion' => 'nullable|string',
            'autor_id' => 'sometimes|exists:autores,id',
            'categoria_id' => 'sometimes|exists:categorias,id',
        ];
    }
}
