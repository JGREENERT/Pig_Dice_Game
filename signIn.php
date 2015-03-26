<!DOCTYPE HTML>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="IndexStyle.css">
    <title>Joe and Jesse's Pig Game</title>
</head>
<h3>Joe and Jesse's Pig Game</h3>
<body>
<?php
$link = mysqli_connect("cis.gvsu.edu", "greenerj", "greenerj1234", "greenerj");

if(mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}

$pos = 0;
foreach ($_POST as $value) {
    $container[$pos] = $value;
    $pos++;
}

$user = $container[0]."";
$password = $container[1]."";

$user = mysqli_real_escape_string($link, $user);
$password = mysqli_real_escape_string($link, $password);

$results = mysqli_query($link, "SELECT *
FROM pigDB
WHERE uName='$user' AND pWord='$password'")
or die(mysqli_error($link));

if($results->num_rows == 0) {
    //TODO: return back to login with error message
    echo "Incorrect Username or Password";
}

else {
    mysqli_query($link, "UPDATE pigDB
    SET loggedOn=1
    WHERE uName='$user'")
    or die(mysqli_error($link));

    echo("User Signed in<br>");
    //TODO: Send to PigGameSelect
}
mysqli_close($link);

?>
</body>
</html>
