<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpedienteClinico extends Model
{
    use HasFactory;

    protected $table = 'expedientes_clinicos';

    protected $fillable = [
        'paciente_id',
        'numero_expediente',
        'antecedentes',
        'alergias',
        'observaciones',
    ];

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }
}

