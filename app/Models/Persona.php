<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apellido',
        'ci_numero',
        'sexo',
        'telefono',
        'direccion',
        'ciudade_id',
    ];

    public function ciudade()
    {
        return $this->belongsTo(Ciudade::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function docentes()
    {
        return $this->hasMany(Docente::class);
    }

    public function administradores()
    {
        return $this->hasMany(Docente::class);
    }
}
