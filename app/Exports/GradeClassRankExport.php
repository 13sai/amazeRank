<?php

namespace App\Exports;

use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GradeClassRankExport implements FromArray, WithHeadings
{
    /**
    * @return array
    */
    public function array(): array
    {
        $arr = ['class'];
        foreach (Grade::SUBJECTS as $sub=>$v) {
            $arr[] = DB::raw('avg('.$sub.')');
        }
        return Grade::select($arr)->groupBy('class')->get()->toArray();
    }

    public function headings(): array
    {
        $arr = ['班级'];
        foreach (Grade::SUBJECTS as $sub=>$v) {
            $arr[] = $v;
        }
        return $arr;
    }
}
