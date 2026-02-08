<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authUser = auth()->user();
        if (!$authUser) return false;

        $routeUser = $this->route('user');

        // ADMIN: puede ver a cualquiera
        if ($authUser->hasRole('Admin')) {
            return true;
        }

        // BIBLIOTECARIO: puede ver usuarios
        if ($authUser->hasRole('Bibliotecario') && $authUser->hasPermissionTo('ver_usuario')) {
            return true;
        }

        // USUARIO NORMAL: solo puede verse a sí mismo
        if (
            $authUser->hasRole('Usuario') &&
            $authUser->hasPermissionTo('ver_usuario') &&
            $authUser->id === $routeUser->id
        ) {
            return true;
        }

        return false;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
