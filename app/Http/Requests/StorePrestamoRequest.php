<?php

namespace App\Http\Requests;

use App\Models\Prestamo;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePrestamoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        if (!$user) return false;

        return $user->hasRole('Admin') || $user->hasRole('Bibliotecario');
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'libro_id' => [
                'required',
                'exists:libros,id',
                function ($attribute, $value, $fail) {
                    // Asegúrate de que 'activo' coincida exactamente con lo que hay en BD
                    $existe = \App\Models\Prestamo::where('libro_id', $value)
                        ->where('estado', 'activo')
                        ->exists();

                    if ($existe) {
                        $fail('El libro ya tiene un préstamo activo.');
                    }
                }
            ],
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|string',
        ];
    }
}
