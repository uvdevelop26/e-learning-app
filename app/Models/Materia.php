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

    //scope filter
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orwhere('codigo', 'like', '%' . $search . '%')
                    ->orWhereHas('semestre', function ($query) use ($search) {
                        $query->where('nombre', 'like', '%' . $search . '%')
                            ->orWhere('codigo', 'like', '%' . $search . '%');
                    });
            });
        });
    }
}
