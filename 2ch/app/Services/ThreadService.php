<?php

namespace App\Services;

use App\Repositories\MessageRepository;
use App\Repositories\ThreadRepository;
use App\Models\Thread;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThreadService
{
    /**
     * @var MessageRepository
     */
    protected $message_repository;

    /**
     * @var ThreadRepository
     */
    protected $thread_repository;

    /**
     * ThreadService constructor.
     *
     * @param MessageRepository $message_repository
     * @param ThreadRepository $thread_repository
     */
    public function __construct(
        MessageRepository $message_repository,
        ThreadRepository $thread_repository
    ) {
        $this->message_repository = $message_repository;
        $this->thread_repository = $thread_repository;
    }

    /**
     * Create new thread and first new message.
     *
     * @param array $data
     * @param string $user_id
     * @return Thread $thread
     */
    public function createNewThread(array $data, string $user_id)
    {
        DB::beginTransaction();
        try {
            $thread_data = $this->getThreadData($data['name'], $user_id);
            $thread = $this->thread_repository->create($thread_data);

            $message_data = $this->getMessageData($data['content'], $user_id, $thread->id);
            $this->message_repository->create($message_data);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());
            throw new Exception($error->getMessage());
        }
        DB::commit();

        return $thread;
    }

    /**
     * Get Thread Data
     *
     * @param string $thread_name
     * @param string $user_id
     * @return array
     */
    public function getThreadData(string $thread_name, string $user_id)
    {
        return [
            'name' => $thread_name,
            'user_id' => $user_id,
            'latest_comment_time' => Carbon::now(),
        ];
    }

    /**
     * Get Message Data
     *
     * @param string $message
     * @param string $user_id
     * @param string $thread_id
     * @return array
     */
    public function getMessageData(string $message, string $user_id, string $thread_id)
    {
        return [
            'body' => $message,
            'user_id' => $user_id,
            'thread_id' => $thread_id,
        ];
    }

    /**
     * Get paginated threads.
     *
     * @param integer $per_page
     * @return Thread $threads
     */
    public function getThreads(int $per_page)
    {
        $threads = $this->thread_repository->getPaginatedThreads($per_page);
        $threads->load('user', 'messages.user'); // Eager load。N+1問題回避
        return $threads;
    }
}
