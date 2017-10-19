<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //消息通知相关功能引用
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *只可以操作$fillable属性中定义的字段
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 在Eloquent模型中借助对table属性的定义，指明当前要操作的数据表为“users”表
     *
     * @var string
     */
    protected $table = 'users';
}
