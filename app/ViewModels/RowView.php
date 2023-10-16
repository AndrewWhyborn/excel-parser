<?php


namespace App\ViewModels;


use App\Models\Row;
use Illuminate\Database\Eloquent\Collection;

class RowView
{
    public function getRowsGroupByDate(): Collection
    {
        return Row::all()->groupBy("date")->sortBy("date");
    }
}
