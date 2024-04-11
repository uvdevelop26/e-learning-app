<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Anuncio extends Model
{
    use HasFactory;

    protected $table = 'anuncios';

    protected $fillable = [
        'titulo',
        'descripcion',
        'user_id',
        'anunciable_id',
        'anunciable_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function materiales()
    {
        return $this->hasMany(Materiale::class);
    }

    //especificamos que se trata de una tabla polimórfica
    public function anunciable()
    {
        return $this->morphTo();
    }
}
