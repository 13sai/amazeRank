<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GradeRankExport implements FromCollection, WithHeadings
{

    private $column = [];

    public function __construct()
    {
        $this->column = array_merge(['id' => 'id'], Grade::FRONT_MAP);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $list = Grade::select(array_keys($this->column))->get();
        return $list;
    }

    public function headings() :array
    {
        return array_values($this->column);
    }
}
