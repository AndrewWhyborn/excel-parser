<?php

namespace App\Http\Controllers;

use App\Http\Requests\RowsPostRequest;
use App\Services\RowsServices;
use App\ViewModels\RowView;
use Illuminate\Http\JsonResponse;

class RowsController extends Controller
{
    public function index(RowView $rowView): JsonResponse
    {
        return response()->json(["rows" => $rowView->getRowsGroupByDate()]);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function parse(RowsPostRequest $request, RowsServices $rowsServices): JsonResponse
    {
        return response()->json(["task_id" => $rowsServices->dispatchParsing($request->file("file"))]);
    }
}
