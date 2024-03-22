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
        'codigo',
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

    //scope filter
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('codigo', 'like', '%' . $search . '%')
                    ->orWhere('nombre', 'like', '%' . $search . '%');
            });
        });
    }
}
