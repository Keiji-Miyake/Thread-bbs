<?php

namespace App\Services;

use App\Repositories\ThreadRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageService
{
    /**
     * @var ThreadRepository
     */
    protected $thread_repository;

    /**
     * ThreadService constructor.
     *
     * @param ThreadRepository $thread_repository
     */
    public function __construct(
        ThreadRepository $thread_repository
    ) {
        $this->thread_repository = $thread_repository;
    }

    /**
     * Create new message and first new message.
     *
     * @param array $data
     * @param string $thread_id
     * @return Message $message
     */
    public function createNewMessage(array $data, string $thread_id)
    {
        DB::beginTransaction();
        try {
            $thread = $this->thread_repository->findById($thread_id);
            $message = $thread->messages()->create($data);
            $this->thread_repository->updateTime($thread_id);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());
            throw new Exception($error->getMessage());
        }
        DB::commit();

        return $message;
    }

    /**
     * Convert link from message.
     *
     * @param string $message
     * @return string $message
     */
    public function convertUrl(string $message)
    {
        $message = e($message);
        $pattern = '/((?:https?|ftp|ssh):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $replace = '<a href="$1" target="_blank">$1</a>';
        $message = preg_replace($pattern, $replace, $message);
        return $message;
    }
}
