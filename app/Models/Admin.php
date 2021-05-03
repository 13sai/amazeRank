<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'username',
        'name',
        'role',
        'password',
        'api_token',
    ];

    const ROLE_LIST = [
        1 => [
            'label' => '超级管理员',
            'value' => 1,
            'alias' => 'super'
        ],
        2 => [
            'label' => '普通管理员',
            'value' => 2,
            'alias' => 'admin'
        ]
    ];
}
