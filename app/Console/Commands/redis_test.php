<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class redis_test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis_list_test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        while(true){
            $start = time();
            $list = Redis::zrangebyscore('zlist', $start, $start+1, ['withscores' => true]);
            if($list){
                foreach($list as $v => $k){
                    $value = json_decode($v, true);
                    if(!isset($value['status']) || !$value['status']){
                        Redis::zadd('zlist', $k + 10, json_encode(['order_sn' => $value['order_sn'],'status' => 1]));
                    }
                    var_dump($value['order_sn'] . "--status--" . (isset($value['status']) ? $value['status'] : '无'));
                    Redis::ZREM('zlist', $v);
                }
            }
        }
    }
}
