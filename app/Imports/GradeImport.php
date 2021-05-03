<?php

namespace App\Imports;

use App\Jobs\GradeRankJob;
use App\Models\Grade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;

class GradeImport implements ToArray
{

    public function __construct()
    {
        $this->map = Grade::SUBJECT_MAPPING;
        $this->mapReserve = array_flip($this->map);
    }

    private $header = [];

    private $map = [];

    private $mapReserve = [];

    private $headerIndex = [];

    /**
    * @param Collection $collection
    */
    public function array(Array $collection)
    {
        $this->header = $collection[0];
        unset($collection[0]);
        $this->indexHeader();
        // die;
        return $this->createData($collection);
    }

    public function createData($rows)
    {
        $success = 0;
        foreach ($rows as $row) {
            $new = [];
            foreach ($this->headerIndex as $index=>$v) {
                $new[$v] = $row[$index];
            }

            foreach ($new as $k=>$v) {
                if (empty($v)) {
                    unset($new[$k]);
                }
            }
            (new Grade())->create(
                $new
            );

            // 其他业务代码
            $success++;
        }

        dispatch(new GradeRankJob());

        return $success.'-'.count($rows);
    }

    private function indexHeader()
    {
        foreach ($this->header as $index=>$item) {
            foreach ($this->map as $k=>$subject) {
                if ($subject == $item) {
                    $this->headerIndex[$index] = $k;
                }
            }
        }
        Log::channel('error')->error('indexHeader', [$this->headerIndex]);
    }
}
