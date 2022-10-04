<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;
    public function detalles()
    {
        return $this->hasMany(Detalle::class);
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
