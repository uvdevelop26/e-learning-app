<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    protected $fillable = ['estado'];

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public function administradores()
    {
        return $this->hasMany(Administradore::class);
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }
}
