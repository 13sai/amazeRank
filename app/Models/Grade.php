<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $guarded = ['id'];

    protected $table = 'grades';

    public $timestamps = false;

    const SUBJECT_MAPPING = [
        'class' => '班级',
        'name' => '姓名',
        'student_id' => '学号',
        'chinese' => '语文',
        'math' => '数学',
        'english' => '英语',
        'physics' => '物理',
        'history' => '历史',
        'geography' => '地理赋分',
        'politics' => '政治赋分',
        'biology' => '生物赋分',
        'chemistry' => '化学赋分',
        'select'=> '选科',
    ];

    const FRONT_MAP = [
        'class' => '班级',
        'name' => '姓名',
        'select'=> '选科',
        'student_id' => '学号',
        'chinese' => '语文',
        'chinese_rank'=> '语文排名',
        'math' => '数学',
        'math_rank' => '数学排名',
        'english' => '英语',
        'english_rank' => '英语排名',
        'physics' => '物理',
        'physics_rank' => '物理排名',
        'history' => '历史',
        'history_rank' => '历史排名',
        'geography' => '地理赋分',
        'geography_rank' => '地理排名',
        'politics' => '政治赋分',
        'politics_rank' => '政治排名',
        'biology' => '生物赋分',
        'biology_rank' => '生物排名',
        'chemistry' => '化学赋分',
        'chemistry_rank' => '化学排名',
        'three_grade'=> '三总',
        'three_grade_rank' => '三总排名',
        'six_grade'=> '六总',
        'six_grade_rank'=> '六总排名',
    ];

    const SUBJECTS = [
        'chinese' => '语文',
        'math' => '数学',
        'english' => '英语',
        'physics' => '物理',
        'history' => '历史',
        'geography' => '地理赋分',
        'politics' => '政治赋分',
        'biology' => '生物赋分',
        'chemistry' => '化学赋分',
    ];

    const RANK_SUBJECTS = [
        'chinese',
        'math',
        'english',
        'physics',
        'history',
        'geography',
        'politics',
        'biology',
        'chemistry',
        'three_grade',
        'six_grade'
    ];

    const SELECT_MAP = [
        '史政地',
        '物化地',
        '物化生',
        '物生地',
    ];
}
