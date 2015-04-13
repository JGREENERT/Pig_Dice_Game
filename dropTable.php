<!DOCTYPE html>
<head>
    <title>PIGDB Drop Table</title>
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

    mysqli_query($link, "DROP TABLE Users") or die(mysqli_error($link));

    echo("Table Dropped<br>");

    mysqli_close($link);
}
createTable();
?>
</body>
</html>