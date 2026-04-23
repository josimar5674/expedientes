<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sujeto extends Model
{
    // 🔗 Relación con expediente
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

    // 🔗 Relación con documentos (DNI, etc.)
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    // 🧠 Campos permitidos
    protected $fillable = [
        'tipo',
        'nombre',
        'identificacion',
        'cah',
        'expediente_id' // 👈 recomendado agregarlo
    ];
}