<?php
namespace App\Clases;

use App\Exports\CrecibosExport;
use App\Exports\TrecibosExport;
use App\Models\Recibo;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ReciboClass {
    public function __construct(){}

    public static function buscar()
    {
        $recibo = new ReciboClass();
        return $recibo;
    }

    public function descargar_historial_cliente($cliente){
        return Excel::download(new CrecibosExport($cliente), 'descargar_historial_cliente.xlsx');
    }

    public function descargar_recibos($recibos,$finicio,$ffinal){
        return Excel::download(new TrecibosExport($recibos,$finicio,$ffinal), 'Reporte_de_Recibos.xlsx');
    }

    public function descargar_recibo(Recibo $recibo)
    {
        $formatter = new NumeroALetras();
        $total_letra = $formatter->toMoney($recibo->total, 2, 'QUETZALES', 'CENTAVOS');
        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo', 'total_letra'));
        $consultapdf->setOption(['defaultFont'=>'gothic']);
        $pdfContent = $consultapdf->output();
        $resultado = response()->streamDownload(
            fn () => print($pdfContent),
            $recibo->cliente->name."_".$recibo->femision."recibo.pdf"
        );
        return $resultado;
    }

    public function reenviar(Recibo $recibo){
        $formatter = new NumeroALetras();
        $total_letra = $formatter->toMoney($recibo->total, 2, 'QUETZALES', 'CENTAVOS');
        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo','total_letra'));
        $consultapdf->setOption(['defaultFont'=>'gothic']);
        Mail::send('recibos.comprobante_pdf_correo', compact('recibo','total_letra'), function ($mail) use ($consultapdf, $recibo) {
            $email = $recibo->cliente->email;
            $mail->to([$email]);
            $mail->subject("Espacio Arquitectura");
            $mail->attachData($consultapdf->output(), 'recibo.pdf');
        });
    }

    public function generar_reciboPdf(Recibo $recibo)
    {
        $formatter = new NumeroALetras();
        $total_letra = $formatter->toMoney($recibo->total, 2, 'QUETZALES', 'CENTAVOS');
        $consultapdf = FacadePdf::loadView('recibos.comprobante_pdf', compact('recibo', 'total_letra'));
        $consultapdf->setOption(['defaultFont'=>'gothic']);
        if (! File::exists(storage_path('app/public/') . 'recibospdf/'))
        {
            File::makeDirectory(storage_path('app/public/') . 'recibospdf/');
        }
        $nombreticketpdf ='recibospdf/rec-'.strtotime(date("F j, Y, g:i a"))."-".$recibo->correlativo.'.pdf';
        $consultapdf->save(storage_path('app/public/') . $nombreticketpdf);
        $recibo->path_pdf = $nombreticketpdf;
        $recibo->save();
    }

}

?>
