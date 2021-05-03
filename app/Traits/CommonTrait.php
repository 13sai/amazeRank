<?php
/**
 * Author: sai
 * Date: 2020/10/15
 * Time: 18:12
 */

namespace App\Traits;


use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Redis;

trait CommonTrait
{
    public function getScript()
    {
        return <<<LUA
        return redis.call("set", KEYS[1],  ARGV[1], 'ex', ARGV[2], 'nx')
LUA;
    }


    public function processLock($key, $autoDel = true, $ttl = 60)
    {
        if (Redis::eval($this->getScript(), 1, $key, 1, $ttl)) {
            if ($autoDel) {
                register_shutdown_function(function () use ($key) {
                    Redis::del($key);
                });
            }

            return true;
        }
        throw new ApiException('请不要重复点击');
    }
}