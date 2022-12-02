<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function comprobante(){
        return $this->belongsTo(Recibo::class);
    }

    public function producto(){
        return $this->belongsTo(Servicio::class);
    }

    public static function fechaVencimiento($user_id, $tipo_conceptos_cobro_id = 2){
        return static::orderBy('fechavencimiento','desc')
        ->join("comprobantes", "comprobantes.id", "=", "detalles.comprobante_id")
        ->select("comprobantes.user_id", "detalles.matricula_id as det_matricula_id", "detalles.fechavencimiento", "detalles.*")
        ->where("detalles.matricula_id", "=", $user_id)
        ->where("tipo_conceptos_cobro_id", "=", $tipo_conceptos_cobro_id)
        ->where("comprobantes.cestado", "!=", "anulado")
        ->first();
    }

    public function setMesAttribute($value){
        switch ($value) {
            case "01":
                $this->attributes['mes'] = "enero";
                break;
            case "02":
                $this->attributes['mes'] = "febrero";
                break;
            case "03":
                $this->attributes['mes'] = "marzo";
                break;
            case "04":
                $this->attributes['mes'] = "abril";
                break;
            case "05":
                $this->attributes['mes'] = "mayo";
                break;
            case "06":
                $this->attributes['mes'] = "junio";
                break;
            case "07":
                $this->attributes['mes'] = "julio";
                break;
            case "08":
                $this->attributes['mes'] = "agosto";
                break;
            case "09":
                $this->attributes['mes'] = "setiembre";
                break;
            case "10":
                $this->attributes['mes'] = "octubre";
                break;
            case "11":
                $this->attributes['mes'] = "noviembre";
                break;
            case "12":
                $this->attributes['mes'] = "diciembre";
                break;
        }
    }
}
