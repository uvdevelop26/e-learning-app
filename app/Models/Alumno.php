<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'persona_id',
        'carrera_id',
        'user_id',
        'estado_id'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function clases()
    {
        return $this->belongsToMany(Clase::class);
    }

    //scope filter
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search){
            $query->where(function ($query) use ($search){
                $query->whereHas('persona', function ($query) use ($search){
                    $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('apellido', 'like', '%' . $search . '%')
                    ->orWhere('ci_numero', 'like', '%' . $search . '%');
                });
            });
        });
    }
}
