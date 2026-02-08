<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ShowPrestamoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        if (!$user->hasPermissionTo('ver_prestamo')) return false;

        $prestamo = $this->route('prestamo'); // model binding

        // Admin o Bibliotecario: puede ver cualquier préstamo
        if ($user->hasRole('Admin') || $user->hasRole('Bibliotecario')) {
            return true;
        }

        // Usuario: solo su préstamo
        return $prestamo && $prestamo->user_id === $user->id;
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
