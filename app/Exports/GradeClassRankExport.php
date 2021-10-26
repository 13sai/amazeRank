<?php

namespace App\Exports;

use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GradeClassRankExport implements FromArray, WithHeadings
{
    private $classList;

    private function getClassList()
    {
    }

    /**
    * @return array
    */
    public function array(): array
    {
        $row = [];
        foreach (Grade::SUBJECTS as $sub=>$v) {
            $arr = ['class', DB::raw('avg('.$sub.') as '.$sub)];
            $list  = Grade::select($arr)->where($sub, '>', 0)->groupBy('class')->get()->toArray();
            
            $list = array_column($list, $sub, 'class');
            if (!$this->classList) {
                $this->classList = array_keys($list);
            }

            foreach ($this->classList as $item) {
                $row[$item]['class'] = $item;
                $row[$item][$sub] = $list[$item]??0;
            }
        }


        // dd($row);

        
        return $row;
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
