<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function signup()
    {
        return view('users/create');
    }
}
