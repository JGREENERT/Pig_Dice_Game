<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="IndexStyle.css">
    <title>Joe and Jesse's Pig Game</title>
</head>
<h3>Joe and Jesse's Pig Game</h3>
<body>
<div id="Error">
    <?php
    $pos = 0;
    foreach ($_GET as $value) {
        $container[$pos] = $value;
        $pos++;
    }
    $code = $container[0]."";
    if($code == "true")
    {
        echo "<code style=visibility: hidden>";
        echo "true";
        echo "</code>";
    }
    ?>
</div>
<fieldset>
    <legend>Login</legend>
    <form>
        <code>Username</code>
        <input type="text" name="username">
        <code>Password</code>
        <input type="password" name="password">
        <button id="signIn" formaction="PigGameSelect.php" formmethod="post">Sign In</button>
        <code>Or</code> <br/>
        <button id="signUp" formaction="signUp.php" formmethod="post">Sign Up</button>
    </form>
</fieldset>
</body>
</html>
<script type="text/javascript">
    var error = false;
    function setErrorMessage(message) {
        if(error)
        {
            document.getElementById("Error").removeChild(document.getElementById("Error").firstChild);
        }
        var NANPara = document.createElement("p");
        NANPara.setAttribute('style', "text-shadow: 2px 2px 4px #FFFFFF; font-size:x-large; text-align:center; color: red");
        var NANContent = document.createTextNode(message);
        NANPara.appendChild(NANContent);
        document.getElementById("Error").appendChild(NANPara);
        error = true;
    }
    var Error = document.getElementById("Error").getElementsByTagName("code")[0].textContent;
    if(Error == "true")
    {
        setErrorMessage("Incorrect Username or Password");
    }
</script>

