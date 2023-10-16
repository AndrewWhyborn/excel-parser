<?php

use App\Http\Controllers\RowsController;
use App\Http\Middleware\BasicAuth;
use Illuminate\Support\Facades\Route;

Route::get("/rows", [RowsController::class, "index"])->name("rows.index");
Route::post("/rows/parse", [RowsController::class, "parse"])->name("rows.parse")->middleware(BasicAuth::class);
