<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    //用户更新资料权限：只要当前登录的用户ID与申请修改的用户id相同时才可操作
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
    //管理员删除操作权限：只有当当前操作的用户is_admin字段为1且管理员id与当前登录的id不等时才可操作
    //即：管理员不可自己删除自己
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
