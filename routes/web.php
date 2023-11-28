<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GudangsController;
use App\Http\Controllers\CreteriaController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\TransactionsController;

Route::get('/', function () {
    return view('layouts.main');
});

// Route::resource('statuses', StatusesController::class);
// status
Route::get('statuses', [StatusesController::class, 'index']);
Route::post('statuses', [StatusesController::class, 'store'])->name('statuses.store');
Route::post('statuses/{id}/edit', [StatusesController::class, 'update'])->name('statuses.update');
Route::get('statuses/{id}', [StatusesController::class, 'edit'])->name('statuses.edit');
Route::post('statuses/{id}', [StatusesController::class, 'destroy'])->name('statuses.delete');


// gudangs
Route::get('gudangs/add', [GudangsController::class, 'create']);
Route::resource('gudangs', GudangsController::class);
Route::post('import-gudangs', [GudangsController::class, 'importGudangs']);

// criteria
Route::get('creteria/add', [CreteriaController::class, 'create']);
Route::resource('creteria', CreteriaController::class);
Route::post('import-creteria', [CreteriaController::class, 'importCreteria']);

// alternatif
Route::get('alternatif', [AlternatifController::class, 'index']);
Route::post('alternatif', [AlternatifController::class, 'store'])->name('storeAlternatif');
Route::post('alternatif/{id}/edit', [AlternatifController::class, 'edit'])->name('updateAlternatif');
Route::post('alternatif/{id}', [AlternatifController::class, 'destroy'])->name('deleteAlternatif');

// transaksi
Route::get('transactions', [TransactionsController::class, 'index']);
Route::post('import-transaksi', [TransactionsController::class, 'importTransaksi'])->name('importTransaksi');
Route::get('transactions/{id}', [TransactionsController::class, 'edit'])->name('transaksiEdit');
Route::post('transactions/{id}/edit', [TransactionsController::class, 'update'])->name('transaksiUpdate');
Route::post('transactions/{id}', [TransactionsController::class, 'destroy'])->name('transaksiDelete');
Route::get('topsis-result', [TransactionsController::class, 'topsis'])->name('resultTopsis');
