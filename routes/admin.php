<?php

use App\Http\Controllers\CpeController;
use App\Models\Recibo;
use Illuminate\Support\Facades\Route;
use Luecano\NumeroALetras\NumeroALetras;

//use Luecano\NumeroALetras\NumeroALetras;

Route::view('', 'dashboard');
Route::view('/usuarios', 'gestionar_usuarios')->middleware('can:admin.recibos')->name('admin.recibos');
Route::view('/reporte', 'administrador.recibos.recibos_reporte')->middleware('can:admin.recibos')->name('admin.reportes');

#usuario
Route::view('usuario/cambiar', 'administrador.usuarios.cambiar_password')->middleware('can:admin.recibos')->name('admin.usuario.cambiar');
//Route::view('/historial', 'historial_recibos')->middleware('can:admin.recibos')->name('admin.recibos');
//Route::view('/usuarios', 'gestionar_usuarios');
//$formatter = new NumeroALetras();
//Route::view('/comprobante', 'recibos.comprobante_pdf',['recibo' => Recibo::find(4),'total_letra' => $formatter->toMoney(80, 2, 'QUETZALES', 'CENTAVOS')]);

//conceptos de cobros
Route::resource('productos',ProductoController::class)->middleware('can:admin.pagos.index')->names('admin.conceptos_cobros');
//Cpe
Route::get('/comprobantes',[CpeController::class,'index'])->middleware('can:admin.recibos')->name('admin.pagos.comprobantes');
Route::get('/comprobantes/{id}',[CpeController::class,'factura_boleta'])->middleware('can:admin.recibos')->name('admin.comprobantes.show');
Route::get('/comprobantes/{id}/pdf',[CpeController::class,'pdf'])->middleware('can:admin.recibos')->name('admin.comprobantes.pdf');
Route::get('/comprobantes/{id}/ticket',[CpeController::class,'ticket'])->middleware('can:admin.recibos')->name('admin.comprobantes.ticket');
Route::get('/comprobantes/{id}/xml',[CpeController::class,'xml'])->middleware('can:admin.recibos')->name('admin.comprobantes.xml');
Route::get('/comprobantes/{id}/notacredito',[CpeController::class,'notacredito'])->middleware('can:admin.recibos')->name('admin.comprobantes.notacredito');
Route::get('/comproban',[CpeController::class,'create'])->middleware('can:admin.recibos');
