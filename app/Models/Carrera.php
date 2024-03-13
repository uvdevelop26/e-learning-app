<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carreras';

    protected $fillable = [
        'nombre',
        'duracion',
        'descripcion'
    ];

    public function alumnos()
    {
        return $this->hasMany(User::class);
    }

    public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }
}
