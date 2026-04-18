<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    public function expediente()
{
    return $this->belongsTo(Expediente::class);
}

protected $fillable = [
    'fecha',
    'descripcion',
    'archivo'
];

public function documentos()
{
    return $this->hasMany(Documento::class);
}

}
