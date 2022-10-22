<?php

namespace App\Exports;

use App\Models\Recibo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TrecibosExport implements FromView
{
    private $recibos;
    private $finicio;
    private $ffinal;

    public function __construct($recibos,$finicio,$ffinal)
    {
        $this->recibos = $recibos;
        $this->finicio = $finicio;
        $this->ffinal = $ffinal;
    }

    use Exportable;
    public function view(): View
    {
        return view('administrador.recibos.trecibos_usuarios', [
            'recibos' => $this->recibos,
            'finicio' => $this->finicio,
            'ffinal'  => $this->ffinal,
        ]);
    }
}
