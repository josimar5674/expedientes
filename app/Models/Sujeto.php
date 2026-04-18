<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sujeto extends Model
{
    public function expediente()
{
    return $this->belongsTo(Expediente::class);
}
protected $fillable = [
    'tipo',
    'nombre',
    'identificacion',
    'cah'
];

}
