<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        if (!$user) return false;

        return
            $user->hasRole('Admin') ||
            $user->hasRole('Bibliotecario');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',

            'direccion' => 'required|string|min:10|max:255',

            'telefono' => 'required|digits:9',

            'email' => 'required|email|unique:users',

            'password' => 'required|min:8',

            'role' => 'required|in:Usuario,Bibliotecario',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Mensajes personalizados
    |--------------------------------------------------------------------------
    */

    public function messages(): array
    {
        return [
            'nombre.required' =>
                'El nombre es obligatorio.',

            'direccion.required' =>
                'La dirección es obligatoria.',

            'direccion.min' =>
                'La dirección es demasiado corta.',

            'telefono.required' =>
                'El teléfono es obligatorio.',

            'telefono.digits' =>
                'El teléfono debe tener 9 dígitos.',

            'email.required' =>
                'El email es obligatorio.',

            'email.email' =>
                'El email no es válido.',

            'email.unique' =>
                'Ese email ya está registrado.',

            'password.required' =>
                'La contraseña es obligatoria.',

            'password.min' =>
                'La contraseña debe tener mínimo 8 caracteres.',
        ];
    }
}
