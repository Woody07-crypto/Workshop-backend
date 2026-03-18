<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'dui',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'nota',
    ];

    public function expedienteClinico(): HasOne
    {
        return $this->hasOne(ExpedienteClinico::class);
    }

    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class);
    }
}

