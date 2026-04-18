<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    public function expediente()
{
    return $this->belongsTo(Expediente::class);
}

protected $fillable = [
    'fecha',
    'titulo',
    'descripcion',
    'archivo'
];
}
