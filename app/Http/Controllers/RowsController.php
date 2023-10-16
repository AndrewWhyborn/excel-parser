<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RowsController extends Controller
{
    public function parse(Request $request): JsonResponse
    {
        return response()->json(["working" => "yes"]);
    }
}
