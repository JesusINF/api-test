<?php

use App\Http\Controllers\API\NotesController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post("/register", [UserController::class, "register"]);
    Route::post('/login', [UserController::class, 'login']);
});

Route::group(['prefix'=>'v1/user','middleware' => 'auth:sanctum'],function () {
    Route::get("/profile", [UserController::class, 'profile']);
    Route::get("/logout",[UserController::class,'logout']);
    Route::put("/update",[UserController::class, 'update']);
    Route::delete('/delete',[UserController::class,'delete']);
});

Route::group(['prefix'=>'v1/note','middleware' => 'auth:sanctum'],function () {
    Route::post("/add", [NotesController::class, 'add']);
    Route::put("/update/{id}",[NotesController::class,'update']);
    Route::delete("/delete/{id}",[NotesController::class, 'delete']);
    Route::get("/notes",[NotesController::class, 'notes']);
});
