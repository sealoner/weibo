<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //创建微博
    public function store(Request $request)
    {
        $this->validate($request, [
            'content'   =>  'required|max:140'
        ]);
        Auth::user()->statuses()->create([
            'content'   =>  $request->content
        ]);
        return redirect()->back();
    }

    //删除微博
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博删除成功');
        return redirect()->back();
    }
}
