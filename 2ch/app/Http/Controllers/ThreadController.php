<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadRequest;
use App\Message;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index'); //ログインしているユーザがstoreメソッドにアクセスできるように
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('threads.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        // save Thread
        $thread = new Thread();
        $thread->name = $request->name;
        $thread->user_id = Auth::id();
        $thread->latest_comment_time = Carbon::now();
        $thread->save();

        // save Message
        $message = new Message();
        $message->user_id = Auth::id();
        $message->thread_id = $thread->id;
        $message->body = $request->content;
        $message->save();

        // redirect to index method
        return redirect()->route('threads.index')->with('success', 'スレッドの新規作成が完了しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
