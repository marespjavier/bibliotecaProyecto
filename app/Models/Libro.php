<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'isbn',
        'anyo_publicacion',
        'descripcion',
        'imagen_url',
        'autor_id',
        'categoria_id',
    ];

    /*
      Añadimos disponible automáticamente al JSON
    */
    protected $appends = [
        'disponible',
    ];

    /*
      Relaciones
    */

    public function autor()
    {
        return $this->belongsTo(Autor::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    /*
      Disponibilidad calculada
    */

    public function getDisponibleAttribute()
    {
        $prestamoActivo = $this->prestamos()
            ->whereIn('estado', ['activo', 'retrasado'])
            ->exists();

        return !$prestamoActivo;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
