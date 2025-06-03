<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\EventController;

Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
Route::get('/leads/search', [LeadController::class, 'search'])->name('leads.search');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::redirect('/', '/leads');
