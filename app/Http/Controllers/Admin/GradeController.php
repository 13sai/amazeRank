<?php
/**
 * Author: sai
 * Date: 2021/05/03
 * Time: 14:57
 */

namespace App\Http\Controllers\Admin;

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
            'select_list' => Grade::SELECT_MAP
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

        return $model;
    }

    public function download(Request $request)
    {
        $query = $this->filter($request);
        return Excel::download((new GradeRankExport()), 'rank.xlsx');
    }

    public function classDownload()
    {
        return Excel::download((new GradeClassRankExport()), 'class.xlsx');
    }
}