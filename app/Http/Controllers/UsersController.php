<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //设置中间件过滤机制
    public function __construct()
    {
        $this->middleware('auth', [
            'except'    =>  ['show', 'create', 'store', 'index']
        ]);

        //使用Auth中间件提供的guest选项，用于指定只允许未登录的用户才可以访问注册页面
        $this->middleware('guest', [
            'only'  =>['create'],
        ]);
    }

    //显示用户列表
    public function index()
    {
        //获取user表中所有的用户信息
        $users = User::paginate(10);
        return view('users/index', compact('users'));
    }

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

        //注册成功之后用户自动登录
        Auth::login($user);
        session()->flash('success','注册成功！您好'.$request->name.',欢迎来到Weibo App~');
        return redirect()->route('users.show',[$user->id]);
    }

    /**
     * 用户编辑资料
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 用户更新数据验证，需要获取
     * 1、当前用户的登录信息
     * 2、用户提交的资料更新信息
     * @param User $user
     * @param Request $request
     */
    public function update(User $user, Request $request)
    {
            $this->validate($request, [
            'name'      =>  'required|max:50',
            'password'  =>  'nullable|min:6|confirmed',
        ]);

            $this->authorize('update', $user);

        //如果用户不想对当前的密码做修改，则密码表单不输入任何东西
        //同时，获取当前用户在数据库中的密码，作为本次更新的密码
        $data = [];
        $data['name'] = $request->name;
        if(!$request->password) {
            $data['password'] = $user['password'];
        }else{
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '恭喜你，资料更新成功~');

        return redirect()->route('users.show', $user->id);
    }

    //删除用户操作
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '用户删除成功');
        return back();
    }
}
