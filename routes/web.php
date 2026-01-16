<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public invoice share view (no auth required)
Route::get('invoices/{invoice}/share-view', [InvoiceController::class, 'shareView'])->name('invoices.share.view');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('module.dashboard.dashboard');
    })->name('dashboard');

    Route::get('appointments/availability', [AppointmentController::class, 'getAvailability'])->name('appointments.availability');
    Route::resource('appointments', AppointmentController::class);
    Route::put('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::resource('customers', CustomerController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('staff', StaffController::class);
    Route::post('staff/{staff}/documents', [StaffController::class, 'storeDocument'])->name('staff.documents.store');
    Route::resource('rooms', RoomController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('invoices/{invoice}/share', [InvoiceController::class, 'share'])->name('invoices.share');
    Route::resource('offers', OfferController::class);
    Route::resource('inventory', InventoryItemController::class);
    Route::post('inventory/{inventory}/adjust', [InventoryItemController::class, 'adjustQuantity'])->name('inventory.adjust');
    Route::get('inventory/{inventory}/movements', [InventoryItemController::class, 'getMovements'])->name('inventory.movements');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/download', [ReportController::class, 'download'])->name('reports.download');
});
