<?php
/**
 * Author: sai
 * Date: 2020/12/26
 * Time: 14:27
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;


class SystemNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $title;

    private $content;

    private $type;

    private $robot;

    const DD_URL = 'https://oapi.dingtalk.com';

    /**
     * Create a new job instance.
     *
     * @param $title
     * @param string $content
     * @param string $type text, markdown
     * @param int $robot
     */
    public function __construct($title, $content = '', $type = 'markdown', $robot = 1)
    {
        //
        $this->title = $title;
        $this->content = $content;
        $this->type = $type;
        $this->robot = $robot;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        switch ($this->type){
            case 'markdown':
                $params = [
                    'msgtype' => $this->type,
                    $this->type => [
                        'title' => $this->title.'[飞火]',
                        'text' => $this->content
                    ]
                ];
                break;
            default:
                $params = [
                    'msgtype' => $this->type,
                    $this->type => [
                        'content' => $this->content.'[飞火]',
                    ]
                ];
                break;

        }
        $params = json_encode($params, JSON_UNESCAPED_UNICODE);

        $uri = self::URL_MAPPING[$this->robot];
        $this->getClient()->request('POST', $uri, [
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8'
            ],
            'body' => $params
        ]);
    }

    const URL_MAPPING = [
        1 => '/robot/send?access_token=@',
        2 => '/robot/send?access_token=@',
        3 => '/robot/send?access_token=@',
    ];

    public function getClient()
    {
        return new Client([
            'base_uri' => 'https://oapi.dingtalk.com',
            'timeout'  => 30,
            'verify' => false
        ]);
    }
}
