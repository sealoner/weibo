<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    //创建登录页面
    public function create()
    {
        return view('sessions/create');
    }

    //登录验证
    public function store(Request $request)
    {
        $this->validate($request,[
            'email'     =>  'required|email|max:255',
            'password'  =>  'required|min:6',
        ]);

        //创建一个credentials数组，用来存放用户传来的身份信息
        $credentials = [
            'email'     =>  $request->email,
            'password'  =>  $request->password,
        ];
        //然后使用laraavel中的Auth验证类中的attempt方法对数据进行验证
//        $user_info = Auth::user();
//        dd($user_info->name);
        if(Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来');
            return redirect()->route('users.show', [Auth::user()]);
        }else{
            session()->flash('danger', '对不起，您的邮箱或密码有误，请重新输入~');
            return redirect()->back();
        }
    }

    //销毁会话（退出登录）
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '退出成功');
        return redirect()->route('login');
    }
}
