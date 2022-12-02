<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detalles(){
        return $this->hasMany(Detalle::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function operaciones(){
        return $this->hasMany(Detalle::class);
    }

    public function empresa(){
        return $this->belongsTo(Emisor::class);
    }

    public function emisor(){
        return $this->belongsTo(Emisor::class);
    }

    public function cajero(){
        return $this->belongsTo(User::class, 'cajero_id');
    }

    public function moneda(){
        return $this->belongsTo(Moneda::class);
    }
}
