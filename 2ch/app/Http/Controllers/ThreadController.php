<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadRequest;
use App\Message;
use App\Services\ThreadService;
use App\Thread;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * @var threadService
     */
    protected $thread_service;

    /**
     * Create a new controller instance.
     *
     * @param ThreadService $thread_service
     * @return void
     */
    public function __construct(
        ThreadService $thread_service // インジェクション
    )
    {
        $this->middleware('auth')->except('index'); //ログインしているユーザがstoreメソッドにアクセスできるように
        $this->thread_service = $thread_service; // プロパティに代入
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
        try {
            $data = $request->only(
                ['name', 'content']
            );
            $this->thread_service->createNewThread($data, Auth::id()); // new せず $this-> の形で呼び出せる。（インジェクションした為）
        } catch (Exception $error) {
            return redirect()->route('threads.index')->with('error', 'スレッドの新規作成に失敗しました。');
        }

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
