<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MachineController;
use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\Admin\ContactDetailController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Frontend\PageViewController;
use App\Http\Controllers\Frontend\SubmissionController as FrontendSubmissionController;

Route::get('/admin/login', [AuthController::class, 'login'])->name('login');
Route::post('/admin/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pages', PageController::class);
    Route::resource('machines', MachineController::class);
    Route::resource('cards', CardController::class);
    Route::resource('contact-details', ContactDetailController::class);
    Route::resource('submissions', SubmissionController::class);
    Route::post('submissions/{submission}/reply', [SubmissionController::class, 'reply'])->name('submissions.reply');
});

Route::get('/', [PageViewController::class, 'home'])->name('home');
Route::get('/{slug}', [PageViewController::class, 'show'])->name('page.show');
Route::post('/contact/submit', [FrontendSubmissionController::class, 'store'])->name('submission.store');

