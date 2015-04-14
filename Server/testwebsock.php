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

    function __construct($addr, $port)
    {
        parent::__construct($addr, $port);
        $this->roomsDAO = new RoomsDAO();
        $this->roomsJoinedDAO = new RoomsJoinedDAO();
    }

    protected function process($user, $message)
    {
        $split = explode(":", $message);
        $command = $split[0];

        if ($command == "admin create table command") {
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
        $count = count($this->rooms);

        switch ($command) {
            case "create room":
                $this->createRoom($user, $values);
                break;

            case "join room":

                break;

            case "delete room":

                break;

            case "start game":
                $this->sendMessageToAllClientsInTheSameRoomName("start game", $values);
                break;

            case "end turn":
                $this->sendMessageToAllClientsInTheSameRoomName("end turn", $values);
                break;

            case "roll dice":
                $this->sendMessageToAllClientsInTheSameRoomName("roll dice", $values);
                break;

            case "my name is":
                $name = $split[1];
                $user->name = $name;
                break;

            default:

                break;
        }

        /*
        switch ($command) {
            case "create room":
                echo "creating new room $values \n";
                $this->rooms[$values] = new Room(2, 2, 100, "Bentleyj");
                $this->rooms[$values]->addUser($user);
                $this->send($user, "room created: $values");
                $this->roomsDAO->insertIntoTable(2, 2, 100, "Bentleyj");
                break;
            case "join room":
                echo "join room $values \n";
                $this->rooms[$values]->addUser($user);
                //$this->send($user, "Joining room: $values");
                break;
            case "leave room":
                echo "leave room $values \n";
                $this->send($user, "Leave room: $values");
                // if we are the owner of the room, delete the room
                if ($this->rooms[$values]->getOwnerName() == $user->name) {

                } else {
                    //remove just the user
                    $this->rooms[$values]->removeUser($user);
                }
                break;
            case "delete room":
                echo "delete room $values \n";
                unset($this->rooms[$values]);
                $this->send($user, "Deleting room: $values");
                break;
            case "end turn":
                break;
            default:
                echo "default case \n";
        }
        */
    }

    //var_dump($this->rooms);

    //foreach ($this->users as $user2) {
    //    $this->send($user2, $message);
    //}

    private function createRoom($user, $roomInfo) {
        echo "creating new room\n";
        $split = explode($roomInfo, ",");
        $NOP = $split[0];
        $PTW = $split[1];
        $NOD = $split[2];
        $roomOwner = $split[3];
        $roomNumber = $this->roomsDAO->insertIntoTable($NOP, $NOD, $PTW, $roomOwner); // DAO SQL structure slightly diff than view
        $this->rooms[$roomNumber] = new Room($NOP, $PTW, $NOD, $roomOwner);

        $this->joinRoom($user, $roomNumber);
        $this->send($user, "room created:$roomNumber");
    }

    private function joinRoom($user, $roomNumber){
        $this->rooms[$roomNumber]->addUser($user);
        $this->roomsJoinedDAO->insertIntoTable($roomNumber, $user->name);
    }

    private function leaveRoom($user, $roomNumber) {
        $this->rooms[$roomNumber]->removeUser($user);
    }

    private function deleteRoom($user, $roomNumber) {

    }

    private function sendMessageToAllClientsInTheSameRoomName($message, $roomNumber) {
        foreach ($this->rooms[$roomNumber]->users as $user2) {
            $this->send($user2, $message);
        }
    }

    protected function connected($user)
    {
        // Do nothing: This is just an echo server, there's no need to track the user.
        // However, if we did care about the users, we would probably have a cookie to
        // parse at this step, would be looking them up in permanent storage, etc.
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
$echo = new echoServer("148.61.162.206", "9000");
//$echo = new echoServer("localhost", "9000");


try {
    $echo->run();
} catch (Exception $e) {
    $echo->stdout($e->getMessage());
}
