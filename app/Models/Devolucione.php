<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucione extends Model
{
    use HasFactory;

    protected $table = 'devoluciones';

    protected $fillable = [
        'recomendacion',
        'devuelto',
        'puntos',
        'entrega_id'
    ];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class);
    }

    public function materiales()
    {
        return $this->morphMany(MaterialeTarea::class, 'materiable');
    }
}
