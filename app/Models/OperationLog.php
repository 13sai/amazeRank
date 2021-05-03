<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    protected $guarded = ['id'];

    protected $table = 'admin_operation_log';
}
