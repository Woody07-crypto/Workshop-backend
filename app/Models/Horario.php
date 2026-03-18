<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'medico_id',
        'inicio_at',
        'fin_at',
        'estado',
    ];

    protected $casts = [
        'inicio_at' => 'datetime',
        'fin_at' => 'datetime',
    ];

    public function medico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function cita(): HasOne
    {
        return $this->hasOne(Cita::class, 'horario_id');
    }
}

