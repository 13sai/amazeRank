<?php
/**
 * Author: sai
 * Date: 2021/05/03
 * Time: 14:57
 */

namespace App\Http\Controllers\Admin;

use App\Exports\ClassRankExport;
use App\Exports\GradeClassRankExport;
use App\Exports\GradeRankExport;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GradeController extends Controller
{
    public function rank(Request $request)
    {
        $model = $this->filter($request);
        return $this->success([
            'list' => $model->get(),
            'columns' => Grade::FRONT_MAP,
            'select_list' => Grade::SELECT_MAP,
            'class_list' => Grade::groupBy('class')->pluck('class'),
            'sortArr' => ['select_rank', 'wl_rank', 
            'six_grade_rank', 'three_grade_rank',
            'chinese_rank', 'math_rank', 'english_rank',
            'physics_rank', 'history_rank', 'geography_rank',
            'politics_rank', 'biology_rank', 'chemistry_rank'
            ]
        ]);
    }


    public function truncate()
    {
        Grade::where('id', '>', 0)->delete();
        return $this->success();
    }

    private function filter($request)
    {
        $params = $request->all();
        $model = new Grade();
        if (!empty($params['select'])) {
            $model = $model->where('select', $params['select']);
        }
        if (!empty($params['name'])) {
            $model = $model->where('name', $params['name']);
        }

        return $model;
    }

    public function download(Request $request)
    {
        $query = $this->filter($request);
        return Excel::download((new GradeRankExport()), 'rank.xlsx');
    }

    public function classDownload(Request $request)
    {
        return Excel::download((new ClassRankExport($request->class)), $request->class.'.xlsx');
    }

    public function avgDownload()
    {
        return Excel::download((new GradeClassRankExport()), 'avg.xlsx');
    }

}