<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    protected $table = 'semestres';

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'carrera_id'
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }

    //scope filter
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orwhere('codigo', 'like', '%' . $search . '%')
                    ->orWhereHas('carrera', function ($query) use ($search) {
                        $query->where('nombre', 'like', '%' . $search . '%')
                            ->orWhere('codigo', 'like', '%' . $search . '%');
                    });
            });
        });
    }
}
