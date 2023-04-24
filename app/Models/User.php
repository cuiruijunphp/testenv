<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    protected $table = "user";
    protected $fillable = ['user_name', 'password'];

    public function insertUser($user_info){
        $this->save($user_info);
    }
}
