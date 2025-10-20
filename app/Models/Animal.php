<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal extends Model
{
    protected $table = 'animales';

    protected $fillable = [
        'arete','especie','raza','sexo','fecha_nacimiento',
        'peso_actual','foto','padre_id','madre_id','activo'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'peso_actual' => 'decimal:2',
        'activo' => 'boolean',
    ];

    // Relaciones pedigrí
    public function padre(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'padre_id');
    }

    public function madre(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'madre_id');
    }

    // Ejemplo: accesor para edad en años
    public function getEdadAnosAttribute()
    {
        return $this->fecha_nacimiento ? $this->fecha_nacimiento->diffInYears(now()) : null;
    }
}
