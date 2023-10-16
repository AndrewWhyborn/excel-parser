<?php

use App\Http\Controllers\RowsController;
use App\Http\Middleware\BasicAuth;
use Illuminate\Support\Facades\Route;

Route::post("/parse", [RowsController::class, "parse"])->name("rows.parse")->middleware(BasicAuth::class);
