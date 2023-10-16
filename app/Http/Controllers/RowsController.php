<?php

namespace App\Http\Controllers;

use App\Http\Requests\RowsPostRequest;
use App\Services\RowsServices;
use Illuminate\Http\JsonResponse;

class RowsController extends Controller
{
    public function parse(RowsPostRequest $request, RowsServices $rowsServices): JsonResponse
    {
        return response()->json(["task_id" => $rowsServices->dispatchParsing($request->file("file"))]);
    }
}
