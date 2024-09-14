<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as ro;

ro::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

ro::prefix('/student')
    ->group(function () {
        ro::get('/', [StudentController::class, 'getStudent']);
        ro::get('/{id}', [StudentController::class, 'getOnlyStudent']);
        ro::post('/', [StudentController::class, 'createStudent']);
        ro::put('/{id}', [StudentController::class, 'updateStudent']);
        ro::patch('/{id}', [StudentController::class, 'deleteStudent']);
        ro::delete('/{id}', [StudentController::class, 'destroyStudent']);
    });
