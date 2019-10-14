<?php
namespace app;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $chat;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
        $this->chat = new \SplQueue();
    }

    function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
        $this->clients->detach($conn);
    }

    function onMessage(ConnectionInterface $from, $msg) {
        foreach($this->clients as $client)
        {
            $client->send($msg);
        }
        $this->chat->enqueue($msg);
    }
}