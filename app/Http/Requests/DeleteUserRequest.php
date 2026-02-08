<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authUser = auth()->user();
        if (!$authUser) return false;

        // Solo Admin
        if (!$authUser->hasRole('Admin')) return false;

        // Opcional: evitar borrarse a sí mismo
        $routeUser = $this->route('user');
        if ($authUser->id === $routeUser->id) return false;

        return true;
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
