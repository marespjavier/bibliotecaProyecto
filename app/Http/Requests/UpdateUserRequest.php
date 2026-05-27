<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authUser = auth()->user();
        if (!$authUser) return false;

        $routeUser = $this->route('user');

        // Admin
        if ($authUser->hasRole('Admin')) return true;

        // Bibliotecario con permiso
        if ($authUser->hasRole('Bibliotecario') && $authUser->hasPermissionTo('editar_usuario')) return true;

        // Usuario: solo su propio usuario
        if ($authUser->hasRole('Usuario') && $authUser->id === $routeUser->id) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'nombre' =>
                'sometimes|string|max:255',

            'direccion' =>
                'sometimes|required|string|min:10|max:255',

            'telefono' =>
                'sometimes|required|digits:9',

            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'password' =>
                'sometimes|nullable|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'direccion.required' =>
                'La dirección es obligatoria.',

            'direccion.min' =>
                'La dirección es demasiado corta.',

            'telefono.required' =>
                'El teléfono es obligatorio.',

            'telefono.digits' =>
                'El teléfono debe tener 9 dígitos.',
        ];
    }
}
