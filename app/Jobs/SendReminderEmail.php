<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
//    protected $user;
    protected $user_info;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $user_info = [])
    {
        //
//        $this->user = $user;
        $this->user_info = $user_info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
//        $user = $this->user;
//        $mailer->send('emails.reminder',['user'=>$user],function($message) use ($user){
//            $message->to($user->email)->subject('新功能发布');
//        });
        try {
            file_put_contents("1.txt", var_dump($this->user_info), FILE_APPEND);
//            file_put_contents("1.txt", ($this->user_info), FILE_APPEND);
//            User::saved($this->user);
            $user = new User();
            User::create($this->user_info);
//            \DB::table('user')->insertGetId($this->user_info);
//            $user->insert($this->user_info);
        }catch(Exception $exception){
            file_put_contents("1.txt", $exception->getMessage(), FILE_APPEND);
        }
    }

    public function failed()
    {
        // Called when the job is failing...
        $content = json_encode($this->user);
        file_put_contents("1.txt", $content, FILE_APPEND);
    }
}
