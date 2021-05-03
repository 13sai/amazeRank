<?php
/**
 * Author: sai
 * Date: 2020/12/27
 * Time: 14:57
 */

namespace App\Http\Controllers\Admin;


use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Imports\GradeImport;
use App\Services\OSSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CommonController extends Controller
{
    public function uploadImage(Request $request)
    {
        $file = $request->file('file');
        if (!$file || !$file->isValid()) {
            throw new ApiException('请上传png,jpg格式图片');
        }

        $ext = $file->getClientOriginalExtension();     // 扩展名
        $filename = date('dHis') . uniqid() . '.' . $ext;
        $path = $file->storeAs('excel', $filename);
        $res = Excel::import(new GradeImport(), storage_path('app/excel/'.$filename));
        return $this->success([]);
    }

    // public function 
}