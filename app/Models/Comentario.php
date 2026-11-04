<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    protected $table = 'comentario';

    protected $fillable = ['noticia_id', 'mensaje', 'valoracion'];

    public function noticia(): BelongsTo {
        return $this->belongsTo(Noticia::class);
    }

    // Regla 2: solo se puede editar o borrar durante 5 minutos
    public function puedeModificarse(): bool {
        return $this->created_at->gt(now()->subMinutes(5));
    }
}