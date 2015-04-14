<?php
/**
 * Created by IntelliJ IDEA.
 * User: greenerj
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
    private $deleteSQL = "DROP TABLE greenerj.Rooms";

    private function connect()
    {
        // Create an mysqli object connected to the database.
        echo "before connection\n";
        $connection = new mysqli("cis.gvsu.edu", "greenerj", "greenerj1234");
//        $connection = new mysqli("127.0.0.1", "greenerj", "greenerj1234", "greenerj", 3306);
        echo "after connection\n";

        // Complain if the the connection fails.  (This would have to be more graceful
        // in a production environment)
        if (!$connection || $connection->connect_error) {
            die('Unable to connect to database [' . $connection->connect_error . ']');
        }
        $connection->select_db("greenerj");
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
        $insertSQL = "INSERT INTO greenerj.Rooms (numOfPlayers, numOfDice, scoreToWin, ownerName) values ('$numOfPlayers', '$numOfDice', '$scoreToWin', '$ownerName')";

        $c = $this->connect();
        if (mysqli_query($c, $insertSQL)) {
            //echo "Insert Successful<br>";
            return $this->selectLastInsertID();
        } else {
            //echo "Error inserting! : " . mysqli_error($c) . "\n";
        }
    }

    public function selectStar()
    {
        $selectStarSQL = "SELECT * FROM greenerj.Rooms";
        $c = $this->connect();
        return $c->query($selectStarSQL);
    }

    public function selectLastInsertID() {
        $selectSQL = "SELECT LAST_INSERT_ID()";
        $c = $this->connect();
        return $c->query($selectSQL);
    }

    public function selectWhereUserNameEquals($userName) {
        $selectUser = "SELECT * FROM greenerj.Rooms r WHERE r.ownerName = $$userName";
        $c = $this->connect();
        return $c->query($selectUser);
    }
}
?>