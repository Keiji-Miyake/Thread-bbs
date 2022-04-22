<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Repositories\ThreadRepository;
use App\Services\ThreadService;
use Exception;

class ThreadController extends Controller
{
    /**
     * The ThreadService implementation
     *
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
     * Create a new controller instance.
     *
     * @param ThreadService $thread_service
     * @param ThreadRepository $thread_repository
     * @return void
     */
    public function __construct(
        ThreadService $thread_service, // インジェクション
        ThreadRepository $thread_repository
    ) {
        $this->middleware('auth:admin');
        $this->thread_service = $thread_service; // プロパティに代入
        $this->thread_repository = $thread_repository;
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


    public function destroy($id)
    {
        try {
            $this->thread_repository->deleteThread($id);
        } catch (Exception $error) {
            dd($error);
            return redirect()->route('admin.threads.index')->with('error', 'スレッドの削除に失敗しました。');
        }

        return redirect()->route('admin.threads.index')->with('success', 'スレッドを削除しました。');
    }
}
