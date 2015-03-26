<!DOCTYPE html>
<head>
    <title>PIGDB Create Table</title>
</head>
<body>
<?php
/*Creating the mysql Table*/
function createTable()
{
    $link = mysqli_connect("cis.gvsu.edu", "greenerj", "greenerj1234", "greenerj");

    if(mysqli_connect_errno()){
        echo mysqli_connect_error();
        exit();
    }

    mysqli_query($link, "CREATE TABLE pigDB(
    uName VARCHAR(32) NOT NULL,
    pWord VARCHAR(16) NOT NULL,
    loggedOn boolean NOT NULL default 0,
    admin boolean NOT NULL default 0
)") or die(mysqli_error($link));

    echo("Table Created<br>");

    mysqli_close($link);
}
createTable();
?>
</body>
</html>

