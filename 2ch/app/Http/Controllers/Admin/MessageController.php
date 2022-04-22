<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\MessageRepository;
use App\Thread;
use Exception;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * The MessageRepository implementation.
     *
     * @var MessageRepository
     */
    protected $message_repository;

    /**
     * Create a new controller instance.
     *
     * @param MessageRepository $message_repository
     */
    public function __construct(
        MessageRepository $message_repository
    ) {
        $this->middleware('auth:admin');
        $this->message_repository = $message_repository;
    }


    public function destroy(Thread $thread, $id)
    {
        try {
            $this->message_repository->deleteMessage($id);
        } catch (Exception $error) {
            return redirect()->route('admin.threads.show', $thread->id)->with('error', 'メッセージの削除に失敗しました。');
        }

        return redirect()->route('admin.threads.show', $thread->id)->with('success', 'メッセージを削除しました。');
    }
}
