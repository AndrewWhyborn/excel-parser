<?php


namespace App\Services;


use App\Jobs\ParseChunk;
use App\Models\Row;
use Illuminate\Support\Facades\Redis;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RowsServices
{
    /**
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function dispatchParsing($file): string
    {
        $dataRows = $this->getDataRows($file);
        $formattedRows = $this->formatRows($dataRows);

        $uid = uniqid();
        Redis::set($uid, 0);

        Row::truncate();
        foreach (array_chunk($formattedRows, 1000) as $rowsChunk)
            ParseChunk::dispatch($rowsChunk, $uid);

        return $uid;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function getDataRows($file): array
    {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $highestDataRow = $worksheet->getHighestDataRow();

        return $worksheet->rangeToArray("A2:C{$highestDataRow}");
    }

    private function formatRows(array $rows): array
    {
        $formattedRows = [];

        for ($i = 0; $i < count($rows); $i++) {
            if ($rows[$i][0] === null || $rows[$i][1] === null || $rows[$i][2] === null) continue;

            $formattedRows[] = [
                "id" => $rows[$i][0],
                "name" => $rows[$i][1],
                "date" => Date::excelToDateTimeObject($rows[$i][2])->format("Y-m-d")
            ];
        }

        return $formattedRows;
    }
}
