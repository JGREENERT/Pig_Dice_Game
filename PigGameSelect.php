<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="SelectStyle.css">
    <title>Joe and Jesse's Pig Game</title>
</head>
<h3>Joe & Jesse's PigGame!</h3>
<?php
function signIn()
{
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
        header('Location: index.php?error=true');
    }

    else {
        mysqli_query($link, "UPDATE pigDB
        SET loggedOn=1
        WHERE uName='$user'")
        or die(mysqli_error($link));

        //echo("User Signed in<br>");
    }
    mysqli_close($link);

    echo "<h1 id=uName style=visibility: hidden>";
    echo $user."";
    echo "<h1>";
}

if(isset($_POST))
{
    signIn();
}
?>

<script src="PigGameView.js"></script>
<script src="PigGamePlayer.js"></script>
<script src="PigGameDice.js"></script>
<script src="PigGameEngine.js"></script>
<script src="PigGameControl.js"></script>
<script type="text/javascript">

    /*Initializing the View*/
    var PGV = PigGameView.init();
    var preferredColor;
    var preferredName = document.getElementById("uName").textContent;
    console.log(preferredName);

    /*
     * Gets previous settings preferences if the
     * browser hasn't been closed since last visit to
     * the page.
     */
    function getCookie()
    {
        var cookie = document.cookie;
        console.log(cookie);
        var settings = cookie.split(";");
        var values = settings[0].split("=");

        if (values[0] == "name") {
            preferredName = values[1];
            preferredColor = values[3];
            console.log(preferredName);
            console.log(preferredColor);

            document.getElementById("pName").value = preferredName;
            var radioButtons = document.getElementsByName("borderColor");
            for (var i = 0; i < radioButtons.length; i++) {
                if (radioButtons[i].value == preferredColor)
                    radioButtons[i].checked = true;
            }
            updateBorderColor();
        }
        else
            document.getElementById("pName").value = preferredName;
    }

    /*Sets the cookie to expire now*/
    function deleteCookie()
    {
        document.cookie += "; expires=Thu, 01 Jan 1970 00:00:00 GMT;";
        console.log(document.cookie);
    }

    /*
     * Updates the Border Color with a Color Specified
     * in the Settings Form.
     */
    function updateBorderColor() {
        var radioButtons = document.getElementsByName("borderColor");
        var fs = document.getElementsByTagName("fieldset");
        var bs = document.getElementsByTagName("button");
        for (var i = 0; i < radioButtons.length; i++)
            if (radioButtons[i].checked) {
                PGV.preferredColor = radioButtons[i].value;
                for (var j = 0; j < fs.length; j++)
                    fs[j].style.borderColor = PGV.preferredColor;
                for (var k = 0; k < bs.length; k++)
                    bs[k].style.backgroundColor = PGV.preferredColor;
            }
    }
</script>
<body>
<div id="Error"></div>
<div id="InfoForms">
    <fieldset>
        <legend>Player Form</legend>
        <div id="Outer Form">
            <form style="width: 100%">
                <code>Number of Players</code>
                <input type="text" name="NOP" id="NOP" value="4"><br/>
                <code>Points to Win</code>
                <input type="text" name="PTW" id="PTW" value="100"><br/>
                <code>Number of Dice</code>
                <input type="text" name="NOD" id="NOD" value="2"><br/>
                <button id="submit"><code style=" font-size: small;
    color: White;
    text-shadow: 2px 2px 4px #000000;">Set</code></button>
            </form><br/>
        </div>
        <div id="Inner Form"></div>
    </fieldset>
</div>
<div id="Settings">
    <fieldset>
        <legend>Settings</legend>
        <form>
            <code>Border Colors</code><br>
            <input type="radio" name="borderColor" value="hotpink" onclick="updateBorderColor()"><code style="color: hotpink">Hotpink</code>
            <br>
            <input type="radio" name="borderColor" value="green" onclick="updateBorderColor()"><code style="color: green">Green</code>
            <br>
            <input type="radio" name="borderColor" value="blue" onclick="updateBorderColor()"><code style="color: blue">Blue</code>
            <br>
            <input type="radio" name="borderColor" value="red" onclick="updateBorderColor()"><code style="color: red">Red</code>
            <br>
            <code>User Name:</code> <input type="text" id="pName" name="prefName" readonly="readonly">
        </form>
    </fieldset>
</div><br/>
<div id="Game">
    <fieldset style="border-color: hotpink; width: 27%; margin:auto;">
        <div id="GameOutput">
            Begin rolling dice!
        </div>
        <div id="Dice"></div>
        <div id="accumulatedValue">
            Accumulated Value:
        </div>
    </fieldset><br/>
    <fieldset style="border-color: hotpink; width: 23%; margin:auto;">
        <button id="RD"><code style=" font-size: small;
    color: White;
    text-shadow: 2px 2px 4px #000000;">Roll the dice!</code></button>
        <button id="END"><code style=" font-size: small;
    color: White;
    text-shadow: 2px 2px 4px #000000;">End turn!</code></button>
        <div id="PlayersDiv">
        </div>
    </fieldset><br/>
    <fieldset style="border-color: hotpink; width: 11%; margin:auto;">
        <button id="RESET"><code style=" font-size: small;
    color: White;
    text-shadow: 2px 2px 4px #000000;">Reset Game!</code></button>
        <button id="AUTO"><code style=" font-size: small;
    color: White;
    text-shadow: 2px 2px 4px #000000;">Automate</code></button>
    </fieldset>
</div>
<div id="logOut">
    <form action="logOut.php" method="post">
        <input style="visibility: hidden" type="text" name="uName" readonly="readonly"></br>
        <button></button>
    </form>
</div>
</body>
</html>
<script type="text/javascript">
    getCookie();

    /*Set up Log Out Button*/
    var currentUser = document.getElementById("pName").value;
    var logOut = document.getElementById("logOut");
    logOut.getElementsByTagName("button")[0].textContent = "Log Out: " + currentUser;
    logOut.getElementsByTagName("input")[0].value = currentUser;
    logOut.addEventListener("submit", deleteCookie);

    /*Validate Input in the View*/
    document.getElementById("Outer Form").addEventListener("submit", PGV.validateInput);
</script>