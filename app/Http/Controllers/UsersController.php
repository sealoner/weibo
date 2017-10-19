<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create()
    {
        return view('users/create');
    }

    public function show(User $user)
    {
        return view('users/show', compact('user'));
    }

    //用来处理用户注册验证的相关方法
    public function store(Request $request)
    {
        $this->validate($request, [
                'name'      =>  'required|max:50',
                'email'     =>  'required|unique:users|email|max:255',
                'password'  =>  'required|confirmed|min:6',
            ]);
        $user = User::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'password'  =>  bcrypt($request->password),
        ]);
        session()->flash('success','注册成功！您好'.$request->name.',欢迎来到Weibo App~');
        return redirect()->route('users.show',[$user->id]);
    }
}
