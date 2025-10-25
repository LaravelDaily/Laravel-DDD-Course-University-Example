<?php

use Illuminate\Support\Facades\Route;
use StudentAdmission\Presentation\Controllers\CourseController;
use StudentAdmission\Presentation\Controllers\StudentApplicationController;
use StudentAdmission\Presentation\Controllers\StudentController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/', [StudentApplicationController::class, 'index'])->name('index');
        Route::get('/create', [StudentApplicationController::class, 'create'])->name('create');
        Route::post('/', [StudentApplicationController::class, 'store'])->name('store');
        Route::get('/{id}', [StudentApplicationController::class, 'show'])->name('show');
        Route::post('/{id}/accept', [StudentApplicationController::class, 'accept'])->name('accept');
        Route::post('/{id}/reject', [StudentApplicationController::class, 'reject'])->name('reject');
    });

    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('/{id}', [CourseController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{id}', [CourseController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/{id}', [StudentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StudentController::class, 'update'])->name('update');
    });
});
