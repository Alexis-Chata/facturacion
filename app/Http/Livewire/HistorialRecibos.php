<?php

namespace App\Http\Livewire;

use App\Mail\TestMail;
use App\Models\Cliente;
use App\Models\Recibo;
use App\Models\Servicio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class HistorialRecibos extends Component
{
    public $finicio;
    public $ffinal;
    public $hcliente;
    public $listaServicios, $servicioSeleccionado;
    public $cantidad, $costo, $total;

    public function  mount($cliente_id)
    {
        $this->servicioSeleccionado = 4;
        $this->cantidad = 1;
        $this->costo = 100;
        $this->total = $this->cantidad * $this->costo;
        $this->listaServicios = Servicio::all();
        $this->hcliente = Cliente::find($cliente_id);
        if ($this->hcliente->recibos != "[]") {
            $this->finicio = $this->hcliente->recibos->first()->femision;
            $this->ffinal = $this->hcliente->recibos->last()->femision;
        } else {
            $this->finicio = null;
            $this->ffinal = null;
        }
    }

    public function updatedCantidad()
    {
        $this->total = $this->cantidad * $this->costo;
    }

    public function updatedcosto($value)
    {
        $this->updatedCantidad();
    }

    public function render()
    {
        return view('livewire.historial-recibos');
    }

    public function agregar_item()
    {
    }

    public function descargar_informe()
    {
    }
    public function descargar_recibo(Recibo $recibo)
    {
        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo'));
        $pdfContent = $consultapdf->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "recibo.pdf"
        );
    }
    public function editar()
    {
    }
    public function reenviar(Recibo $recibo)
    {
        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo'));
        Mail::send('recibos.comprobante_pdf', compact('recibo'), function ($mail) use ($consultapdf, $recibo) {
            $email = $recibo->cliente->email;
            $mail->to([$email]);
            $mail->subject("Espacio Arquitectura");
            $mail->attachData($consultapdf->output(), 'recibo.pdf');
        });

        /* Mail::to($recibo->cliente->email)->send(new TestMail($recibo),function ($mail) use ($consultapdf){
            $mail->attachData($consultapdf->output(),'recibo.pdf');
        });*/
    }
}
