<!DOCTYPE html>
<head>
    <title>PIGDB Insert Table</title>
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
$password = $container[1]."";

echo "Hello";
echo $user."";
echo $password."";


$user = mysqli_real_escape_string($link, $user);
$password = mysqli_real_escape_string($link, $password);


$results = mysqli_query($link, "SELECT *
    FROM pigDB
    WHERE uName='$user'")
or die(mysqli_error($link));

if($results->num_rows == 0) {
    mysqli_query($link, "INSERT INTO pigDB (uName, pWord)
    VALUES ('$user', '$password')")
    or die(mysqli_error($link));

    header('Location: index.php');
}
else{
   header('Location: signUp.php?error=true');
}

mysqli_close($link);
?>
</body>
</html>