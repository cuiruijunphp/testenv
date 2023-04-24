<?php

namespace App\Http\Controllers;

use App\Jobs\LogWrite;
use App\Jobs\SendReminderEmail;
use App\Models\User;
use App\Notifications\MessageNotify;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\Connectors\RedisConnector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use Notifiable;

    public function testenv(){
        dd(env('APP_ENV'));
    }


    public function insertUser(){
        echo 222;
        try {
            $array = [
                'user_name' => 'test',
                'password' => 'test123',
            ];
//            $job =  (new SendReminderEmail(new User(), $array))->onQueue("email");
//            $this->dispatch($job);
//            $user = new User();
//            $user->save();
            $this->dispatch((new SendReminderEmail($array))->onQueue("email3"));
        }catch (\Exception $e){
            echo $e->getMessage();
        }

    }

    public  function test(){
        $user = new User();
        $user_info = [
            'user_name' => 'test' . date('Y-m-d H:i:s'),
            'password' => 'test' . date('Y-m-d H:i:s'),
        ];
        $user->insert([$user_info]);
        $content = "插入数据成功，插入数据为: " . json_encode($user_info) . PHP_EOL;
        dispatch(new LogWrite("2.txt", $content))->onQueue('log')
        ->delay(now()->addSeconds(3))
        ;
    }

    public function notify_con(){
        $user = new User();
        $invoice = "I see u";
//        $noty = new Notifiable();
        $notify_obj = new MessageNotify("notify_list");
//        var_dump();
        $user->notify($notify_obj);
    }

    public function show_con(){
        $notify_key = "notify_list";
        $data = Redis::Lrange($notify_key, 0 -1);
        foreach ($data as $notification) {
            var_dump($notification);
        }
    }

    public function get_user_info(){
        $userCacheKey = "user_test_prefix";
        $userCacheKey1 = "user_json";
        $data = [
            "user_name"=>"cui",
            "email"=>"cuidddd@163.com",
            "id"=>11,
        ];
        $put = Cache::put($userCacheKey, $data, 3600);
        $put = Cache::put($userCacheKey1, json_encode($data), 3600);
        var_dump($put);


        $var = Cache::get($userCacheKey);

        dd(Cache::getStore()) ;
        dd($var);
    }

    public function redis_test()
    {
        $key = time() + 3;
        Redis::zadd('zlist', $key, json_encode(['order_sn' => 'sn1']));
        Redis::zadd('zlist', $key, json_encode(['order_sn' => 'sn2']));
        Redis::zadd('zlist', $key, json_encode(['order_sn' => 'sn3']));
        Redis::zadd('zlist', $key, json_encode(['order_sn' => 'sn4']));
        Redis::zadd('zlist', $key, json_encode(['order_sn' => 'sn5']));

        Redis::expire('zlist', 100);

        var_dump(Redis::zrangebyscore('zlist', 0, $key + 1,['withscores' => true]));
    }
}
