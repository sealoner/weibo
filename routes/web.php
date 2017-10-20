<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('/signup', 'UsersController@create')->name('signup'); //注册页面

Route::resource('/users', 'UsersController');

//会话路由
Route::get('/login', 'SessionController@create')->name('login');   //登录页面
Route::post('/login', 'SessionController@store')->name('login');    //登录验证
Route::delete('/logout', 'SessionController@destroy')->name('logout');    //销毁会话（退出登录）
//验证邮箱发送的URL
Route::get('/signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');
//忘记密码和重置密码的路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');