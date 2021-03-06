<?php
/**
 * Created by IntelliJ IDEA.
 * User: bentleyj
 * Date: 4/9/15
 * Time: 3:02 PM
 */

namespace DAO;


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
    private $deleteSQL = "DROP TABLE bentleyj.RoomsJoined";

    private function connect()
    {
        // Create an mysqli object connected to the database.
        $connection = new mysqli("127.0.0.1", "bentleyj", "bentleyj1234");

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

    public function insertIntoTable($id, $userName)
    {
        $insertSQL = "INSERT INTO bentleyj.RoomsJoined (id, uName) values ('$id', '$userName')";

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
        $selectStarSQL = "SELECT * FROM bentleyj.RoomsJoined";
        $c = $this->connect();
        return $c->query($selectStarSQL);
    }
}
?>