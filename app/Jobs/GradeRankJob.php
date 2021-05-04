<?php

namespace App\Jobs;

use App\Models\Grade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;

class GradeRankJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->calculateSum();
        $this->generateRank();
        $this->amazeRank();
    }


    // 计算总分
    public function calculateSum()
    {
        Grade::where("id", ">", 0)->update([
            'three_grade' => DB::raw("chinese + math + english")
        ]);

        $arr = array_keys(Grade::SUBJECTS);
        $sql = implode('+', $arr);
        Grade::where("id", ">", 0)->update([
            'six_grade' => DB::raw($sql)
        ]);
    }

    public function generateRank() 
    {
        foreach (Grade::RANK_SUBJECTS as $v) {
            $this->rank($v);
        }        
    }

    private function rank($v) 
    {
        $list = Grade::select(['id', $v])->where($v, '>', 0)->orderBy($v, 'DESC')->get()->toArray();
        $tmp = 0;
        $last = 1;
        foreach($list as $index=>$item) {
            if ($tmp != $item[$v]) {
                $tmp = $item[$v];
                $last = $rank = $index + 1;
            } else {
                $rank = $last;
            }
            
            Grade::where(['id' => $item['id']])->update([
                $v.'_rank' => $rank
            ]);
        }
    }

    private function amazeRank() 
    {
        foreach(['物', '史'] as $v) {
            $this->selectRank($v, 'wl_rank');
        }

        foreach(Grade::SELECT_MAP as $v) {
            $this->selectRank($v, 'select_rank');
        }
    }

    private function selectRank($key, $column)
    {
        $v = 'six_grade';
        $list = Grade::select(['id', $v])
        ->where('select', 'like', $key."%")
        ->orderBy($v, 'DESC')->get()->toArray();
        $tmp = 0;
        $last = 1;
        foreach($list as $index=>$item) {
            if ($tmp != $item[$v]) {
                $tmp = $item[$v];
                $last = $rank = $index + 1;
            } else {
                $rank = $last;
            }
            
            Grade::where(['id' => $item['id']])->update([
                $column => $rank
            ]);
        }
    }

}
