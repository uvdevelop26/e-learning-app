<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialeTarea extends Model
{
    use HasFactory;

    protected $table = 'materiale_tareas';

    protected $fillable = [
        'nombre',
        'url',
        'materiable_id',
        'materiable_type'
    ];

    /* tabla polimórfica */
    public function materiable()
    {
        return $this->morphTo();
    }
}
