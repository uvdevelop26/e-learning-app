<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $table = 'clases';

    protected $fillable = [
        'codigo',
        'materia_id',
        'docente_id',
        'estado_id'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class);
    }

    public function unidades()
    {
        return $this->hasMany(Unidade::class);
    }

    //relación uno a muchos polimórfica

    public function anuncios()
    {
        return $this->morphMany(Anuncio::class, 'anunciable');
    }
}
