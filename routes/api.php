<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/students',[StudentController::class,"index"])-> name("student.index");
Route::post('/students',[StudentController::class,"store"])-> name("student.store");

Route::get('/exam',[ExamController::class,"index"])-> name("exam.index");
Route::post('/exam',[ExamController::class,"store"])-> name("exam.store");

Route::delete('/exam',[ExamController::class,"destroy"])-> name("exam.destroy");


