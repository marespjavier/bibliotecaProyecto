<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReadAllUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        // Admin siempre
        if ($user->hasRole('Admin')) return true;

        // Bibliotecario si tiene permiso de ver usuarios
        if ($user->hasRole('Bibliotecario') && $user->hasPermissionTo('ver_usuario')) return true;

        return false;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [];
    }
}
