<?php

namespace App\Console\Commands;

use App\Jobs\GradeRankJob;
use Illuminate\Console\Command;

class InitAdmin extends Command
{
      /**
     * 命令行的名称及签名。
     *
     * @var string
     */
    protected $signature = 'initAdmin';

    /**
     * 命令行的描述
     *
     * @var string
     */
    protected $description = '初始化';

    /**
     * 创建新的命令行实例。
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 执行命令行。
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        dispatch(new GradeRankJob());
    }

}