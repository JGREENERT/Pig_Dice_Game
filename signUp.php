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
        if(isset($_GET))
        {
            echo "<code style=visibility: hidden>";
            echo "true";
            echo "</code>";
        }
    ?>
</div>
<div id="Error"></div>
<div id="signUpForm">
    <fieldset>
        <form action="insertTable.php" method="post">
            <code>Username</code><input type="text" id="uName" name="uName">
            <code>Password</code><input type="password" id="pWord" name="pWord">
            <code>Password Confirmation</code><input type="password" id="pConf">
            <button id="button">Submit</button>
        </form>
    </fieldset>
</div>
</body>
</html>
<script type="text/javascript">
    "use strict";
    var error = false;
    document.getElementById("signUpForm").addEventListener("submit",
            function(event) {
                var uName = document.getElementById("uName").value;
                var pWord1 = document.getElementById("pWord").value;
                var pConf = document.getElementById("pConf").value;
                var uNameError = document.getElementById("uName Error").getElementsByTagName("code")[0].innerText;
                console.log(uNameError);
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
                else if(uNameError == "true")
                {
                    event.preventDefault();
                    setErrorMessage("Sorry that Username is already in use. Please pick a new one");
                    document.getElementById("uName Error").removeChild(document.getElementById("uName Error").firstChild);
                    document.getElementById("uName").value = "";
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
