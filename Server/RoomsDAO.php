<?php
/**
 * Created by IntelliJ IDEA.
 * User: bentleyj
 * Date: 4/9/15
 * Time: 9:37 AM
 */

class RoomsDAO {

    public function RoomsDAO() {

    }

    private $createSQL = "CREATE TABLE Rooms
    (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    numOfPlayers INT(6),
    numOfDice INT(6),
    scoreToWin INT(6),
    ownerName VARCHAR(64) NOT NULL
    )";
    private $deleteSQL = "DROP TABLE bentleyj.Rooms";

    private function connect()
    {
        // Create an mysqli object connected to the database.
        echo "before connection\n";
        $connection = new mysqli("127.0.0.1", "bentleyj", "bentleyj1234");
//        $connection = new mysqli("127.0.0.1", "bentleyj", "bentleyj1234", "bentleyj", 3306);
        echo "after connection\n";

        // Complain if the the connection fails.  (This would have to be more graceful
        // in a production environment)
        if (!$connection || $connection->connect_error) {
            die('Unable to connect to database [' . $connection->connect_error . ']');
        }
        $connection->select_db("bentleyj");
        return $connection;
    }

    public function createTable()
    {
        $c = $this->connect();
        //$c->query($createSQL);

        if (mysqli_query($c, $this->createSQL)) {
            //echo "Table friends created successfully<br>";
        } else {
            return "Error creating table: " . mysqli_error($c) . "<br>";
        }
        return "Created Successfully";
    }

    public function destroyTable()
    {
        $c = $this->connect();
        //$c->query($destroySQL);

        if (mysqli_query($c, $this->destroySQL)) {
            //echo "Table friends destroyed successfully";
        } else {
            return "Error destroying table: " . mysqli_error($c);
        }
        return "Destroyed successfully :'(";
    }

    public function insertIntoTable($numOfPlayers, $numOfDice, $scoreToWin, $ownerName)
    {
        $insertSQL = "INSERT INTO bentleyj.Rooms (numOfPlayers, numOfDice, scoreToWin, ownerName) values ('$numOfPlayers', '$numOfDice', '$scoreToWin', '$ownerName')";

        $c = $this->connect();
        if (mysqli_query($c, $insertSQL)) {
            //echo "Insert Successful<br>";
        } else {
            return "Error inserting! : " . mysqli_error($c) . "\n";
        }
        return "Insert Successful";
    }

    public function selectStar()
    {
        $selectStarSQL = "SELECT * FROM bentleyj.Rooms";
        $c = $this->connect();
        return $c->query($selectStarSQL);
    }

    public function selectWhereUserNameEquals($userName) {
        $selectUser = "SELECT * FROM bentleyj.Rooms r WHERE r.ownerName = $$userName";
        $c = $this->connect();
        return $c->query($selectUser);
    }
}
?>