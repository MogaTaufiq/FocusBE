<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/habits', [HabitController::class, 'index']);
    Route::post('/habits', [HabitController::class, 'store']);
    Route::put('/habits/{id}', [HabitController::class, 'update']);
    Route::delete('/habits/{id_habit}', [HabitController::class, 'destroy']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/notes', [NoteController::class, 'index']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::put('/notes/{id}', [NoteController::class, 'update']);
    Route::delete('/notes/{id_note}', [NoteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/todos', [ToDoController::class, 'index']);
    Route::post('/todos', [ToDoController::class, 'store']);
    Route::put('/todos/{id}', [ToDoController::class, 'update']);
    Route::delete('/todos/{id_todo}', [ToDoController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id_event}', [EventController::class, 'destroy']);
});

// Route::apiResource('events', EventController::class);