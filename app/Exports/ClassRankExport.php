<?php

namespace App\Exports;

use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClassRankExport implements FromArray, WithHeadings
{

    private $column = [];

    private $class;

    public function __construct($class)
    {
        $this->column = array_merge(['id' => 'id'], Grade::FRONT_MAP);
        $this->class = $class;
    }

    /**
    * @return array
    */
    public function array(): array
    {
        $v = 'six_grade_rank';
        $list = Grade::where('class', $this->class)->select(array_keys($this->column))
            // ->where($v, ">", 0)
            ->orderBy($v, 'asc')
            ->get()
            ->toArray();
        // $this->column = array_merge($this->column , ['rank' => '班级排名']);
        $tmp = 0;
        $last = 1;
        foreach($list as $index=>&$item) {
            if ($tmp != $item[$v]) {
                $tmp = $item[$v];
                $last = $rank = $index + 1;
            } else {
                $rank = $last;
            }
            
            $item['rank'] = $rank;
        }
        return $list;
    }

    public function headings() :array
    {
        return array_values(array_merge($this->column , ['rank' => '班级排名']));
    }
}
