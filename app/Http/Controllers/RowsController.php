<?php

namespace App\Http\Controllers;

use App\Http\Requests\RowsPostRequest;
use Illuminate\Http\JsonResponse;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RowsController extends Controller
{
    public function parse(RowsPostRequest $request): JsonResponse
    {
        $spreadsheet = IOFactory::load($request->file('file'));
        $cell = $spreadsheet->getActiveSheet()->getCell('B2');

        return response()->json(["working" => $cell->getValue()]);
    }
}
