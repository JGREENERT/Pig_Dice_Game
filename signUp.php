<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="IndexStyle.css">
    <title>Joe and Jesse's Pig Game</title>
</head>
<h3>Joe and Jesse's Pig Game</h3>
<body>
<div id="uName Error">
    <?php
    if(isset($_GET)) {
        $pos = 0;
        foreach ($_GET as $value) {
            $container[$pos] = $value;
            $pos++;
        }
        $code = $container[0] . "";
        if ($code == "true") {
            echo "<code style=visibility: hidden>";
            echo "true";
            echo "</code>";
        }
    }
    ?>
</div>
<div id="Error"></div>
<div id="signUpForm">
    <fieldset>
        <form action="insertTable.php" method="post">
            <code>Username</code><input type="text" id="uName" name="uName" value="">
            <code>Password</code><input type="password" id="pWord" name="pWord" value="">
            <code>Password Confirmation</code><input type="password" id="pConf" value="">
            <button id="button">Submit</button>
        </form>
    </fieldset>
</div>
</body>
</html>
<script type="text/javascript">
    "use strict";

    /*Username Error Check*/
    if(document.getElementById("uName Error").getElementsByTagName("code")[0] != undefined)
        var uNameError = document.getElementById("uName Error").getElementsByTagName("code")[0].textContent;
    if(uNameError == "true")
    {
        setErrorMessage("Sorry that Username is already in use. Please pick a new one");
        document.getElementById("uName Error").removeChild(document.getElementById("uName Error").firstChild);
        document.getElementById("uName").value = "";
        document.getElementById("pWord").value = "";
        document.getElementById("pConf").value = "";
    }

    var error = false;
    document.getElementById("signUpForm").addEventListener("submit",
            function(event) {
                var uName = document.getElementById("uName").value;
                var pWord1 = document.getElementById("pWord").value;
                var pConf = document.getElementById("pConf").value;
                if(pWord1 == "" || pConf == "" || uName == "")
                {
                    event.preventDefault();
                    var error = document.getElementById("error");
                    console.log("Fields Empty");
                    setErrorMessage("Please Fill in All Fields");
                }
                else if(pWord1 != pConf)
                {
                    event.preventDefault();
                    var error = document.getElementById("error");
                    console.log("Passwords don't match");
                    setErrorMessage("The Password and the Confirmation Password You Entered Don't Match");
                    document.getElementById("pWord").value = "";
                    document.getElementById("pConf").value = "";
                }
            });

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
</script>
