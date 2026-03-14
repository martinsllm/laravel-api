<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    
    Route::apiResource('student', App\Http\Controllers\StudentController::class)->middleware('auth:sanctum');
    Route::apiResource('course', App\Http\Controllers\CourseController::class)->middleware('auth:sanctum');

    Route::post('student/courses', [App\Http\Controllers\StudentCourseController::class, 'store'])->middleware('auth:sanctum');
});
