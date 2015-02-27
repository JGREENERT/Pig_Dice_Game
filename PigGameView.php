<!DOCTYPE html>
<script src="PigGamePlayer.js"></script>
<script src="PigGameDice.js"></script>
<script src="PigGameEngine.js"></script>
<script src="PigGameControl.js"></script>
<script type="text/javascript">

/*Global Variables*/
var set = false;
var error = false;
var control;
var dice;
var players;
var interval;
var PTW;
var preferredColor;
var preferredName;

function setCookie()
{
    document.cookie = "name=" + preferredName + "=color=" + preferredColor;
}

function getCookie()
{
    var cookie = document.cookie;
    console.log(cookie);
    var settings = cookie.split(";");
    console.log(settings[0]);
    var values = settings[0].split("=");

    if(values[0] == "name") {
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
}

function updateBorderColor()
{
    var radioButtons = document.getElementsByName("borderColor");
    var fs = document.getElementsByTagName("fieldset");
    var bs = document.getElementsByTagName("button");
    for(var i = 0; i < radioButtons.length; i++)
        if(radioButtons[i].checked)
        {
            preferredColor = radioButtons[i].value;
            for(var j = 0; j < fs.length; j++)
                fs[j].style.borderColor = preferredColor;
            for(var k = 0; k < bs.length; k++)
                bs[k].style.backgroundColor = preferredColor;
        }
};

function validateInput(event) {
    event.preventDefault();
    if (!set) {
        var message = document.getElementById("Error").childNodes;

        /*Resetting Error Message*/
        if (error) {
            document.getElementById("Error").removeChild(message[0]);
        }

        /*Getting Form Values*/
        var NOP = document.getElementById("NOP").value;
        var PTW = document.getElementById("PTW").value;
        var NOD = document.getElementById("NOD").value;

        /*Input is not a Number*/
        if (isNaN(NOP) || isNaN(PTW) || isNaN(NOD)) {
            console.log("Not a Number");
            setErrorMessage("Please make sure all fields are a number");
        }
        /*Input is Negative*/
        else if (NOP < 0 || PTW < 0 || NOD < 0) {
            console.log("Is Negative");
            setErrorMessage("Please make sure all fields contain a Positive number");
        }

        /*Input is a Decimal*/
        else if (NOP % 1 != 0 || PTW % 1 != 0 || NOD % 1 != 0) {
            console.log("Is a Decimal");
            setErrorMessage("Please make sure all fields contain a Whole number");
        }

        else if(NOP == "" || PTW == "" || NOD == "")
        {
            console.log("Is empty");
            setErrorMessage("Please make sure all fields contain a value");
        }
        else {
            error = false;
            createInnerForm();
        }
    }
    else
        resetForm();

};

/*
 *   Sets the error message for a specified error
 */
function setErrorMessage(message)
{
    var NANPara = document.createElement("p");
    NANPara.setAttribute('style', "text-shadow: 2px 2px 4px #FFFFFF; font-size:x-large; text-align:center; color: red");
    var NANContent = document.createTextNode(message);
    NANPara.appendChild(NANContent);
    document.getElementById("Error").appendChild(NANPara);
    error = true;
};

/*
 *   Creates the form for user to insert player
 *   names and start the game.
 */
var createInnerForm = function () {
    /*Hiding the Settings Box*/
    document.getElementById("Settings").style.display = 'none';

    /*Setting up Player Name HTML*/
    var playerForm = document.createElement("form");
    var numOfPlayers = document.getElementById("NOP").value;
    for (var i = 0; i < numOfPlayers; i++) {
        var playerItem = document.createElement("input");
        playerItem.setAttribute('type', "text");
        playerItem.setAttribute('name', 'Player' + i + 'Name');
        playerItem.setAttribute('id', 'Player' + i);
        playerItem.setAttribute('value', 'Player ' + i);
        playerForm.appendChild(playerItem);
    }
    /*Creating Player Name HTML and adding Play Button*/
    playerForm.appendChild(document.createElement("br"));
    var submitButton = document.createElement("button");
    submitButton.style.backgroundColor = preferredColor;
    submitButton.innerHTML = "Play";
    playerForm.appendChild(submitButton);
    document.getElementById("Inner Form").appendChild(playerForm);
    document.getElementById("Inner Form").addEventListener("submit", startGame);

    /*Setting Preferred Name to Player 0 Spot*/
    if(document.getElementById("pName").value != "") {
        preferredName = document.getElementById("pName").value
        document.getElementById("Player" + 0).value = preferredName;
    }

    /*Changing set to reset event listener*/
    set = true;
    document.getElementById("submit").innerHTML = "Reset";
};

/*
 *   Resets the form if a user wants to make
 *   a different selection
 */
var resetForm = function()
{
    /*Resetting Outer Form Values for Reset*/
    document.getElementById("NOP").value = "";
    document.getElementById("PTW").value = "";
    document.getElementById("NOD").value = "";

    /*Removing the Player Name HTML*/
    var InnerForm = document.getElementById("Inner Form").childNodes;
    document.getElementById("Inner Form").removeChild(InnerForm[0]);

    /*Re-show the Setting Box with same preferred values*/
    document.getElementById("Settings").style.display = 'block';

    /*Changing reset to set event listener*/
    set = false;
    document.getElementById("submit").innerHTML = "Set";
};

/*
 *   Starts the Game by calling the Pig Game View
 *   and creating the UI by manipulating the DOM
 */
var startGame = function(event){
    event.preventDefault();

    setCookie();

    /*Removing "Info Form" HTML*/
    document.getElementById("InfoForms").style.display = 'none';

    /*Adding Game UI HTML*/
    document.getElementById("Game").style.display = 'block';

    /*Starting Game*/
    PTW = document.getElementById("PTW").value;
    var NOP = document.getElementById("NOP").value;
    var NOD = document.getElementById("NOD").value;

    var playerNames = [];
    for (var i = 0; i < NOP; i++) {
        var child = document.createElement("div");
        var name = document.getElementById("Player" + i).value;
        child.id = name;
        child.innerText = name + "'s score: 0";
        document.getElementById("PlayersDiv").appendChild(child);
        playerNames.push(name)
    }


    control = PigGameControl.init(playerNames, NOD, PTW);
    dice = control.getAllDice();
    players = control.getAllPlayers();
    console.log(players);

    document.getElementById("RD").addEventListener("click", rollDiceButtonClicked);
    document.getElementById("END").addEventListener("click", endTurnButtonClicked);
    document.getElementById("RESET").addEventListener("click", resetButtonClicked);
    document.getElementById("AUTO").addEventListener("click", playGameAutomagicallyInterval);
};

function printGameOutput() {
    document.getElementById("GameOutput").innerHTML = control.getMessage();
}

function printPlayersScore(playerNameToPrint, toPrint) {
    document.getElementById(playerNameToPrint).innerText = playerNameToPrint + "'s score: " + toPrint;
    document.getElementById(playerNameToPrint).style.fontWeight = "bold";

    //current player is green background
    if (playerNameToPrint === players[control.getCurrentPlayerNumber()].getName()){
        document.getElementById(playerNameToPrint).style.backgroundColor = "lightgreen";
    }
    else {
        //document.getElementById(playerNameToPrint).style.backgroundColor = "white";
        //document.getElementById(playerNameToPrint).style.backgroundColor = "red";
        var bgColor = new RGBA(0,0,255,(toPrint / PTW));
        document.getElementById(playerNameToPrint).style.backgroundColor = bgColor.getCSS();//(toPrint / scoreToWin);
    }
}

function updateAccumulator() {
    document.getElementById("accumulatedValue").innerHTML = "Accumulated Value: " + control.getAccumulator();
}

function printScores() {
    for (var x = 0; x < control.getNumberOfPlayers(); x++) {
        printPlayersScore(players[x].getName(), players[x].getScore())
    }
    var playerDivs = document.getElementById("PlayersDiv").children;
    playerDivs = Array.prototype.slice.call(playerDivs, 0);
    playerDivs.sort(function(a,b) {
        var val = -1;
        if (a.nodeName === "DIV" && b.nodeName === "DIV") {

            //sort by player score value, (highest on top)s
            val = ((b.innerHTML.split(":")[1]) - (a.innerHTML.split(":")[1]));
        }

        //in the event of a tie in score, sort by player alphabetically
        if (val == 0) {
            return (b.innerText < a.innerText);
        }
        return val;
    });

    //internet taught me i forgot to remove and re-add elements... I'm not very bright
    var parent = document.getElementById('PlayersDiv');
    parent.innerHTML = "";

    for(var i = 0, l = playerDivs.length; i < l; i++) {
        parent.appendChild(playerDivs[i]);
    }

}

function updateDice() {
    var dice = control.getAllDice();
    var diceDiv = document.getElementById("Dice");
    diceDiv.innerHTML = "";
    for (var $d=0; $d < control.getNumberOfDice(); $d++) {
        //var child = document.createElement("div");
        //child.style.width = "100px";
        //child.style.height = "100px";
        //child.float = "left";
        var image = document.createElement("img");
        image.src = "./Images/Dice" + dice[$d].getValue() + ".jpg";
        //child.appendChild(image);
        diceDiv.appendChild(image);
        //diceDiv.appendChild(child);
    }
}

function rollDiceButtonClicked() {
    control.rollDice();
    printGameOutput();
    printScores();
    updateAccumulator();
    updateDice();
}

function endTurnButtonClicked() {
    control.endTurn();
    printGameOutput();
    printScores();
    updateAccumulator();
}

function playGameAutomagically() {
    rollDiceButtonClicked();
    if (control.getAccumulator() > 0 && (Math.random()*5 + 1) <= 4)
        endTurnButtonClicked();
}

function playGameAutomagicallyInterval() {
    interval = setInterval(playGameAutomagically, 1);

}

function resetButtonClicked() {
    control.resetGame();
    printGameOutput();
    printScores();
    updateAccumulator();
    clearInterval(interval);
}

//color methods stolen off of stack overflow :)
function RGBA(red,green,blue,alpha) {
    this.red = red;
    this.green = green;
    this.blue = blue;
    this.alpha = alpha;
    this.getCSS = function() {
        return "rgba("+this.red+","+this.green+","+this.blue+","+this.alpha+")";
    }
}

function setBgOpacity(elem, opac) {
    bgColor.alpha = opac;
    elem.style.backgroundColor = bgColor.getCSS();
}

</script>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="PigGameStyle.css">
    <title>Joe and Jesse's Pig Game</title>
</head>
<h3>Joe & Jesse's PigGame!</h3>
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
                <button id="submit">Set</button>
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
            <input type="radio" name="borderColor" value="hotpink" onclick="updateBorderColor()" checked><code style="color: hotpink">Hotpink</code>
            <br>
            <input type="radio" name="borderColor" value="green" onclick="updateBorderColor()"><code style="color: green">Green</code>
            <br>
            <input type="radio" name="borderColor" value="blue" onclick="updateBorderColor()"><code style="color: blue">Blue</code>
            <br>
            <input type="radio" name="borderColor" value="red" onclick="updateBorderColor()"><code style="color: red">Red</code>
            <br>
            <code>Preferred Name:</code> <input type="text" id="pName" name="prefName" value=" ">
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
        <button id="RD">Roll the dice!</button>
        <button id="END">End turn!</button>
        <div id="PlayersDiv">
        </div>
    </fieldset><br/>
    <fieldset style="border-color: hotpink; width: 11%; margin:auto;">
        <button id="RESET">Reset Game!</button>
        <button id="AUTO">Automate</button>
    </fieldset>
</div>
</body>
</html>
<script type="text/javascript">
    document.getElementById("Outer Form").addEventListener("submit", validateInput);
    getCookie();
</script>
