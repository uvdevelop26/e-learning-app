<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiale extends Model
{
    use HasFactory;

    protected $table = 'materiales';

    protected $fillable = [
        'nombre',
        'url',
        'anuncio_id'
    ];

    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class);
    }
}
