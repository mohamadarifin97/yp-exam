<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('subjects', SubjectController::class);
    });

    // index for admin | lecturer
    Route::middleware(['auth', 'role:admin,lecturer'])
        ->resource('classes', ClassController::class)
        ->only(['index']);

    // rest for admin only
    Route::middleware(['auth', 'role:admin'])
        ->resource('classes', ClassController::class)
        ->except(['index']);

    Route::resource('exams', ExamController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
        ->middleware('role:admin,lecturer');
    Route::get('/exams/{exam}/start', [ExamController::class, 'startExam'])->name('exams.start');
    Route::post('/exams/attempt/{attempt}/submit', [ExamController::class, 'submitExam'])->name('exams.submit');
    Route::get('/exams/attempt/{attempt}/result', [ExamController::class, 'result'])->name('exams.result');
    Route::get('/exams/{exam}/marking', [ExamController::class, 'marking'])->name('exams.marking')->middleware('role:admin,lecturer');
    Route::post('/answers/{answer}/mark', [ExamController::class, 'saveMark'])->name('answers.mark')->middleware('role:admin,lecturer');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
