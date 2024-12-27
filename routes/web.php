<?php

use App\Http\Controllers\ChatbotController;
// use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('conversations', ConversationController::class)->only(['index', 'store', 'show']);

    // Messages Routes //
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::patch('/messages/{conversationId}', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');

    // ChatBot Routes //
    Route::prefix('chatbot')->name('chatbot.')->group(function () {
        Route::get('/', [ChatbotController::class, 'index'])->name('index');
        Route::post('/post', [ChatbotController::class, 'askGPT'])->name('askGPT');
    });

    // News Routes //
});

require __DIR__ . '/auth.php';
