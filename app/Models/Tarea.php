<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'titulo',
        'instruccion',
        'fecha_entrega',
        'hora_entrega',
        'puntos',
        'unidade_id'
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class);
    }

    //relación de uno a muchos polimórfica 
    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'comentable');
    }

    public function materiales()
    {
        return $this->morphMany(MaterialeTarea::class, 'materiable');
    }
}
