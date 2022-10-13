<?php

namespace App\Exports;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CrecibosExport implements FromView
{
    private $cliente;

    public function __construct($cliente)
    {
        $this->cliente = $cliente;
    }

    use Exportable;
    public function view(): View
    {
        return view('administrador.recibos.recibos_usuarios', [
            'cliente' => $this->cliente,
        ]);
    }
}

