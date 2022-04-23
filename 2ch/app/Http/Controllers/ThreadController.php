<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ThreadService;
use App\Http\Requests\ThreadRequest;
use App\Repositories\ThreadRepository;
use Illuminate\Support\Facades\Auth;

use App\Services\SlackNotificationService;

class ThreadController extends Controller
{
    /**
     * @var threadService
     */
    protected $thread_service;

    /**
     * The ThreadRepository implementation
     *
     * @var ThreadRepository
     */
    protected $thread_repository;

    /**
     * The SlackNotificationService implementation.
     *
     * @var SlackNotificationService
     */
    protected $slack_notification_service;

    /**
     * Create a new controller instance.
     *
     * @param ThreadService $thread_service
     * @param ThreadRepository $thread_repository
     * @return void
     */
    public function __construct(
        ThreadService $thread_service, // インジェクション
        ThreadRepository $thread_repository,
        SlackNotificationService $slack_notification_service
    )
    {
        $this->middleware('auth')->except('index'); //ログインしているユーザがstoreメソッドにアクセスできるように
        $this->thread_service = $thread_service; // プロパティに代入
        $this->thread_repository = $thread_repository;
        $this->slack_notification_service = $slack_notification_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = $this->thread_service->getThreads(3);
        $threads->load('messages.user', 'messages.images');
        return view('threads.index', compact('threads'));
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
            $this->slack_notification_service->send(Auth::user()->name . ' が ' . $request->name . 'を立てました！');
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
        $thread = $this->thread_repository->findById($id);
        $thread->load('messages.user', 'messages.images');
        return view('threads.show', compact('thread'));
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
