<?php
/**
 * Created by IntelliJ IDEA.
 * User: greenerj
 * Date: 4/9/15
 * Time: 3:02 PM
 */

class RoomsJoinedDAO {

    public function RoomsJoinedDAO() {

    }

    private $createSQL = "CREATE TABLE RoomsJoined
    (id INTEGER UNSIGNED,
    uName VARCHAR(32) NOT NULL,
    FOREIGN KEY (id) REFERENCES Rooms(id),
    FOREIGN KEY (uName) REFERENCES Users(uName),
    PRIMARY KEY (id, uName)
    )";
    private $deleteSQL = "DROP TABLE greenerj.RoomsJoined";

    private function connect()
    {
        // Create an mysqli object connected to the database.
        $connection = new mysqli("cis.gvsu.edu", "greenerj", "greenerj1234");

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

    public function insertIntoTable($id, $userName)
    {
        $insertSQL = "INSERT INTO greenerj.RoomsJoined (id, uName) values ('$id', '$userName')";

        $c = $this->connect();
        if (mysqli_query($c, $insertSQL)) {
            //echo "Insert Successful<br>";
        } else {
            return "Error inserting! : " . mysqli_error($c) . "\n";
        }
        return "Insert Successful";
    }

    public function deleteFromTableWithUsername($username)
    {
        $deleteSQL = "DELETE FROM greenerj.RoomsJoined rj WHERE rj.username = $username";
        $c = $this->connect();
        if (mysqli_query($c, $deleteSQL)) {
            //echo "Delete Successful<br>";
        } else {
            return "Error deleting! : " . mysqli_error($c) . "\n";
        }
        return "Delete Successful";
    }

    public function deleteFromTableWithId($id)
    {
        $deleteSQL = "DELETE FROM greenerj.RoomsJoined rj WHERE rj.id = $id";
        $c = $this->connect();
        if (mysqli_query($c, $deleteSQL)) {
            //echo "Delete Successful<br>";
        } else {
            return "Error deleting! : " . mysqli_error($c) . "\n";
        }
        return "Delete Successful";
    }

    public function selectStar()
    {
        $selectStarSQL = "SELECT * FROM greenerj.RoomsJoined";
        $c = $this->connect();
        return $c->query($selectStarSQL);
    }
}
?>