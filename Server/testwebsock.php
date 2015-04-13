<?php

require_once('./websockets.php');
require_once('./Room.php');
require_once('./RoomsDAO.php');
require_once('./RoomsJoinedDAO.php');

//require_once('../DAO/RoomsDAO.php');
//require_once('../DAO/RoomsJoinedDAO.php');
class echoServer extends WebSocketServer
{
    //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.

    private $rooms = array();
    private $roomsDAO;
    private $roomsJoinedDAO;

    function __construct($addr, $port) {
        parent::__construct($addr, $port);
        $this->roomsDAO = new RoomsDAO();
        $this->roomsJoinedDAO = new RoomsJoinedDAO();
    }

    protected function process($user, $message)
    {
        $split = explode(":", $message);
        $command = $split[0];

        if ($command == "admin create table command"){
            echo "admin create table command entered\n";
            echo $this->roomsDAO->createTable();
            echo $this->roomsJoinedDAO->createTable();
            return;
        }
        if ($command == "admin delete table command") {
            echo "admin delete table command entered\n";
            echo $this->roomsDAO->destroyTable();
            echo $this->roomsJoinedDAO->destroyTable();
            return;
        }

        $values = $split[1];

        if (isset($this->rooms[$values]) !== true) {

            //these commands are for if the key does NOT exist
            switch ($command) {
                case "create room":
                    echo "creating new room $values \n";
                    $this->rooms[$values] = new Room(2, 2, 100, "Bentleyj");
                    $this->rooms[$values]->addUser($user);
                    $this->send($user, "Creating Room: $values");
                    $this->roomsDAO->insertIntoTable(2, 2, 100, "Bentleyj");
                    break;
                default:
                    echo "That room does not exist, can't execute $command \n";
                    $this->send($user, "That room does not exist, can't execute $command");
            }
        } else {

            //these commands are for if the key exists
            switch ($command) {
                case "create room":
                    echo "room $values already exists\n";
                    $this->send($user, "Room $values already exists");
                    break;
                case "join room":
                    echo "join room $values \n";
                    $this->rooms[$values]->addUser($user);
                    $this->send($user, "Joining room: $values");
                    break;
                case "leave room":
                    echo "leave room $values \n";
                    $this->send($user, "Leave room: $values");
                    // if we are the owner of the room, delete the room
                    if ($this->rooms[$values]->getOwnerName() == $user->name){

                    }
                    else {
                        //remove just the user
                        $this->rooms[$values]->removeUser($user);
                    }
                    break;
                case "delete room":
                    echo "delete room $values \n";
                    unset($this->rooms[$values]);
                    $this->send($user, "Deleting room: $values");
                    break;
                default:
                    echo "default case \n";
            }
        }

        //var_dump($this->rooms);

        //foreach ($this->users as $user2) {
        //    $this->send($user2, $message);
        //}
    }

    protected function connected($user)
    {
        // Do nothing: This is just an echo server, there's no need to track the user.
        // However, if we did care about the users, we would probably have a cookie to
        // parse at this step, would be looking them up in permanent storage, etc.

        /*
         * Parse cookie (session stuff)
         */
    }

    protected function closed($user)
    {
        // Do nothing: This is where cleanup would go, in case the user had any sort of
        // open files or other objects associated with them.  This runs after the socket
        // has been closed, so there is no need to clean up the socket itself here.

        // logout user here


        /*
         * Delete engine potentially
         */
    }
}

//$echo = new echoServer("0.0.0.0", "9000");
//$echo = new echoServer("127.0.0.1", "9000");
$echo = new echoServer("148.61.162.207", "9000");
//$echo = new echoServer("localhost", "9000");


try {
    $echo->run();
} catch (Exception $e) {
    $echo->stdout($e->getMessage());
}
