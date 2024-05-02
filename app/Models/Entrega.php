<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entregas';

    protected $fillable = [
        'completado',
        'puntaje',
        'tarea_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function materiales()
    {
        return $this->morphMany(MaterialeTarea::class, 'materiable');
    }
}
