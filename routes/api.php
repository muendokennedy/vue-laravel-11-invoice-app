<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get_all_invoices', [InvoiceController::class, 'index']);
Route::get('/search_invoice', [InvoiceController::class, 'searchInvoice']);
Route::get('/create_invoice', [InvoiceController::class, 'createInvoice']);
Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
