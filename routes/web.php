<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Invoice\Controller as InvoiceController;
use App\Http\Controllers\Invoice\CreateController as CreateInvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->controller(ProductController::class)->group(function(){
    Route::get('/productos', 'index')->name('products.index');
    Route::get('/productos/crear', 'create')->name('products.create');
    Route::post('/productos', 'store')->name('products.store');
    Route::get('/productos/{product}', 'show')->name('products.show');
    Route::get('/productos/{product}/editar', 'edit')->name('products.edit');
    Route::put('/productos/{product}', 'update')->name('products.update');
    Route::delete('/productos/{product}', 'destroy')->name('products.destroy');
});

Route::middleware(['auth'])->controller(ClientController::class)->group(function(){
    Route::get('/clientes', 'index')->name('clients.index');
    Route::get('/clientes/crear', 'create')->name('clients.create');
    Route::post('/clientes', 'store')->name('clients.store');
    Route::get('/clientes/{client}', 'show')->name('clients.show');
    Route::get('/clientes/{client}/editar', 'edit')->name('clients.edit');
    Route::put('/clientes/{client}', 'update')->name('clients.update');
    Route::delete('/clientes/{client}', 'destroy')->name('clients.destroy');
});

Route::middleware(['auth', 'can:users'])->controller(UserController::class)->group(function(){
    Route::get('/usuarios', 'index')->name('users.index');
    Route::get('/usuarios/crear', 'create')->name('users.create');
    Route::post('/usuarios', 'store')->name('users.store');
    Route::get('/usuarios/{user}', 'show')->name('users.show');
    Route::get('/usuarios/{user}/editar', 'edit')->name('users.edit');
    Route::put('/usuarios/{user}', 'update')->name('users.update');
    Route::delete('/usuarios/{user}', 'destroy')->name('users.destroy');
});

Route::get('/facturas', [InvoiceController::class, 'index'])->name('invoices.index');
Route::get('/facturas/crear', CreateInvoiceController::class)->name('invoices.create');
Route::post('/facturas', [CreateInvoiceController::class, 'store'])->name('invoices.store');
Route::get('/facturas/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/facturas/{invoice}/documento', [InvoiceController::class, 'showDocument'])->name('invoices.show-document');
