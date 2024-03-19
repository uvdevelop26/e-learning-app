<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materias';

    protected $fillable = [
        'nombre',
        'codigo',
        'horas_semanales',
        'plan_estudio',
        'descripcion',
        'semestre_id'
    ];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function clases()
    {
        return $this->hasMany(Clase::class);
    }
}
