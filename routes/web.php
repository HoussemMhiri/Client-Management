<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});


Route::controller(ClientController::class)->group(function () {
    Route::get('clients', 'index')->name('clients.index');
    Route::post('clients/store', 'store')->name('clients.store');
    Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients/destroy/{id}', 'destroy')->name('clients.destroy');
});


Route::controller(FactureController::class)->group(function () {
    Route::get('factures/{client_id}', 'index')->name('factures.index');
    Route::post('factures/{client_id}/store', 'store')->name('factures.store');
    Route::put('/factures/{id}',  'update')->name('factures.update');
    Route::delete('factures/destroy/{id}', 'destroy')->name('factures.destroy');
});


/* Route::get('/client/{clientId}/total-unpaid', [InvoiceController::class, 'showTotalUnpaidAmount']);
Route::get('/client/{clientId}/overdue-invoices', [InvoiceController::class, 'showOverdueInvoices']); */
/* Route::get('factures/{client_id}', [InvoiceController::class, 'showClientInvoices'])->name('invoice.index'); */
