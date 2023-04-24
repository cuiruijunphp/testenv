<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageNotify extends Notification implements ShouldQueue
{
    use Queueable;
    protected $redis_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($redis_name)
    {
        //
        $this->redis_name = $redis_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        return ['mail'];
//        return [RedisChannel::class];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_name' => "test",
            'amount' => 12,
            'content' => "neihao",
        ];

    }

    public function toRedis($notifiable){
        $name=$this->redis_name;

//        sleep(20);//20秒压入等待测试
        Redis::rPush($name,$notifiable->id);//压入队列
    }

    public function toDatabase($notifiable){
        return [
            'user_name' => "test",
            'amount' => 12,
            'content' => "neihao",
        ];
    }

    //这里定义我们的名字
    public function viaQueues()
    {
        return [
            RedisChannel::class => 'notify_li',
            "database" => 'dnotify',
        ];
    }
}
