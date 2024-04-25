<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'contenido',
        'comentable_id',
        'comentable_type',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* tabla polimórfica */
    public function comentable()
    {
        return $this->morphTo();
    }
}
