<?php

use Illuminate\Support\Facades\Route;

Route::view('', 'dashboard');
Route::view('/usuarios', 'gestionar_usuarios')->middleware('can:admin.recibos')->name('admin.recibos');
Route::view('/reporte', 'administrador.recibos.recibos_reporte')->middleware('can:admin.recibos')->name('admin.reportes');

#usuario
Route::view('usuario/cambiar', 'administrador.usuarios.cambiar_password')->middleware('can:admin.recibos')->name('admin.usuario.cambiar');
//Route::view('/historial', 'historial_recibos')->middleware('can:admin.recibos')->name('admin.recibos');
//Route::view('/usuarios', 'gestionar_usuarios');
//Route::view('/comprobante', 'recibos.comprobante_pdf');
