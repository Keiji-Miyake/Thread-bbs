<?php

namespace App\Repositories;

use App\Models\Message;

class MessageRepository
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * MessageRepository Constructor.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Create new Message
     *
     * @param array $data
     * @return Message $message
     */
    public function create(array $data)
    {
        return $this->message->create($data);
    }

    /**
     * Find a message by id
     *
     * @param integer $id
     * @return Message $message
     */
    public function findById(int $id)
    {
        return $this->message->find($id);
    }

    /**
     * Delete message from id
     *
     * @param integer $id
     * @return void
     */
    public function deleteMessage(int $id)
    {
        $message = $this->findById($id);
        return $message->delete();
    }
}
