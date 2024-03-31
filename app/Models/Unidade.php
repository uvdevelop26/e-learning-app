<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $table = 'unidades';

    protected $fillable = [
        'numero',
        'tema',
        'objetivos',
        'clase_id'
    ];

    public function clase()
    {
        return $this->belongsTo(Unidade::class);
    }

    //relación uno a muchos polimórfica

    public function anuncios()
    {
        return $this->morphMany(Anuncio::class, 'anunciable');
    }
}
