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
        'autor_id',
        'categoria_id',
    ];

    public function autor(){
        return $this->belongsTo(Autor::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

}
