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
     * 使用creating，对模型被创建之前的事件进行监听
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($user){
            $user->activation_token = str_random(30);
        });
    }

    /**
     * 在Eloquent模型中借助对table属性的定义，指明当前要操作的数据表为“users”表
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 使用gravatar自动生成用户头像
     */
    public function gravatar($size="100")
    {
        //获取当前数据库中的个人邮箱，将获取到的字符串的两边的引号去掉，并转成小写
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
