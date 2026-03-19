<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    
    Route::apiResource('student', StudentController::class)->middleware('auth:sanctum');
    Route::apiResource('course', CourseController::class)->middleware('auth:sanctum');

    Route::post('student/courses', [StudentCourseController::class, 'store'])->middleware('auth:sanctum');
});
