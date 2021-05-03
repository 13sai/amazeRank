<?php

namespace App\Jobs;

use App\Models\OperationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OperationLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        //
        $this->queue = 'operationLog';
        $this->data = $data;
    }

    private $data;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        OperationLog::create($this->data);
    }
}
