<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Noticia extends Model
{
    protected $table = 'noticia';

    protected $fillable = ['titulo', 'texto'];

    public function comentarios(): HasMany {
        return $this->hasMany(Comentario::class);
    }

    // Regla 3: solo se puede editar durante los primeros 20 minutos
    public function puedeEditarse(): bool {
        return $this->created_at->gt(now()->subMinutes(20));
    }

    // Regla 1: no se puede borrar si tiene comentarios
    public function puedeBorrarse(): bool {
        return !$this->comentarios()->exists();
    }
}