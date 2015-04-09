<!DOCTYPE html>
<html>
<head>
    <title>PIGDB Log Out</title>
</head>
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
echo $user."";

$user = mysqli_real_escape_string($link, $user);

mysqli_query($link, "UPDATE pigDB
        SET loggedOn=0
        WHERE uName='$user'")
or die(mysqli_error($link));

header("Location: index.php");

mysqli_close($link);
?>
</body>
</html>