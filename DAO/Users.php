<?php
/**
 * Created by IntelliJ IDEA.
 * User: bentleyj
 * Date: 4/9/15
 * Time: 8:24 AM
 */

namespace DAO;


class Users
{

    private $createSQL = "CREATE TABLE pigDB(
    uName VARCHAR(32) NOT NULL,
    pWord VARCHAR(16) NOT NULL,
    loggedOn BOOLEAN NOT NULL DEFAULT 0,
    admin BOOLEAN NOT NULL DEFAULT 0
)";
    private $deleteSQL = "DROP TABLE pigDB";

    public function Users()
    {

    }

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

        if (mysqli_query($c, $this->createSQL)) {
            //echo "Table friends created successfully<br>";
        } else {
            return "Error creating table: " . mysqli_error($c) . "<br>";
        }
        return "Created Successfully";
    }

    public function deleteTable()
    {
        $c = $this->connect();

        if (mysqli_query($c, $this->deleteSQL)) {
            //echo "Table pigDB deleteed successfully";
        } else {
            return "Error deleting table: " . mysqli_error($c);
        }
        return "deleted successfully :'(";
    }

    public function insertIntoTable($username, $password)
    {
        $insertSQL = "INSERT INTO pigDB (uName, pWord)
                      VALUES ('$username', '$password')";

        $c = $this->connect();
        if (mysqli_query($c, $insertSQL)) {
            //echo "Insert Successful<br>";
        } else {
            return "Error inserting $username: " . mysqli_error($c) . "\n";
        }
        return "Insert Successful";
    }

    public function selectStar()
    {
        $selectStarSQL = "SELECT * FROM pigDB";
        $c = $this->connect();
        return $c->query($selectStarSQL);
    }
}

if (isset($_POST['action'])) {
    $userDAO = new Users();
    switch($_POST['action']) {
        case 'createTable':
            $userDAO->createTable();
            break;
        case 'deleteTable':
            $userDAO->deleteTable();
            break;
        case 'insertIntoTable':
            //$userDAO->insertIntoTable()
            break;
    }
}


?>
} 