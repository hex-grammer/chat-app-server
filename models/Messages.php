<?php
class Message
{
    // database
    private $conn;
    private $table = 'message';

    // Message properties
    public $messages = [];
    public $message;
    public $user;
    public $target;

    // constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read conversation
    public function readConversation()
    {
        // create query
        $query = "SELECT * FROM " . $this->table . " 
                WHERE :user in (sender) and :target in (receiver) 
                OR :target in (sender) and :user in (receiver)
                ORDER BY send_time DESC";

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // bind params
        $stmt->bindParam(':user', $this->user);
        $stmt->bindParam(':target', $this->target);

        // Execute query
        $stmt->execute();
        $row = $stmt->fetchAll();

        // set properties
        foreach ($row as $msg) {
            $arr = array(
                "id" => $msg['id'],
                "sendTime" => $msg['send_time'],
                "type" => $msg['sender'] == $this->user ? "send" : "receive",
                "message" => $msg['message'],
            );
            array_push($this->messages, $arr);
        }
        return $this->messages;
    }

    // send message
    public function sendMessage()
    {
        // create query
        $query = "INSERT INTO " . $this->table . "  
        VALUES (NULL, :user, :target, :message, current_timestamp())";

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // bind params
        $stmt->bindParam(':user', $this->user);
        $stmt->bindParam(':target', $this->target);
        $stmt->bindParam(':message', $this->message);

        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
