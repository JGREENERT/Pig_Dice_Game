<!DOCTYPE html>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: bentleyj
 * Date: 2/11/15
 * Time: 6:11 PM
 */
?>
<script src="PigGamePlayer.js"></script>
<script src="PigGameDice.js"></script>
<script src="PigGameEngine.js"></script>
<script src="PigGameControl.js"></script>

<html>
    <h3>PigGame!</h3>
<body>
<table>
    <tr>
        <td style="width:15%" valign="top">
            <div id="PlayersDiv">
            </div>
        </td>
        <td style="width:15%" valign="top">
            <button style="background-color:lightgreen" onmousedown=rollDiceButtonClicked()>Roll the dice!</button>
            <button style="background-color:lightgreen" onmousedown=endTurnButtonClicked()>End turn!</button>
            <button onmousedown=playGameAutomagicallyInterval()>Play Game Automagically</button>
            <button style="background-color:lightgreen" onmousedown=resetButtonClicked()>Reset Game!</button>
        </td>
        <td style="width:70%" valign="top">
            <div id="GameOutput">
                Begin rolling dice!
            </div>

            <div id="Dice"></div>

            <div id="accumulatedValue">
                Accumulated Value:
            </div>
        </td>
    </tr>
</table>

<script type="text/javascript">

    var scoreToWin = 100;
    var control = PigGameControl.init(100, 3, scoreToWin);
    var dice = control.getAllDice();
    var players = control.getAllPlayers();
    var interval;

    for (var i = 0; i < control.getNumberOfPlayers(); i++) {
        var child = document.createElement("div");
        child.id = "player" + i;
        child.innerText = "Player " + i + "'s score: 0";
        document.getElementById("PlayersDiv").appendChild(child);
    }

    function printGameOutput() {
        document.getElementById("GameOutput").innerHTML = control.getMessage();
    }

    function printPlayersScore(playerNum, toPrint) {
        document.getElementById("player" + playerNum).innerText = "Player " + playerNum + "'s score: " + toPrint;
        document.getElementById("player" + playerNum).style.fontWeight = "bold";

        //current player is green background
        if (playerNum === control.getCurrentPlayerNumber()){
            document.getElementById("player" + playerNum).style.backgroundColor = "lightgreen";
        }
        else {
            //document.getElementById("player" + playerNum).style.backgroundColor = "white";
            //document.getElementById("player" + playerNum).style.backgroundColor = "red";
            var bgColor = new RGBA(0,0,255,(toPrint / scoreToWin));
            document.getElementById("player" + playerNum).style.backgroundColor = bgColor.getCSS();//(toPrint / scoreToWin);
        }
    }

    function updateAccumulator() {
        document.getElementById("accumulatedValue").innerHTML = "Accumulated Value: " + control.getAccumulator();
    }

    function printScores() {
        for (var x = 0; x < control.getNumberOfPlayers(); x++) {
            printPlayersScore(x, players[x].getScore())
        }
        var playerDivs = document.getElementById("PlayersDiv").children;
        playerDivs = Array.prototype.slice.call(playerDivs, 0);
        playerDivs.sort(function(a,b) {
            var val = -1;
            if (a.nodeName === "DIV" && b.nodeName === "DIV") {

                //sort by player score value, (highest on top)
                val = ((b.innerHTML.split(":")[1]) - (a.innerHTML.split(":")[1]));
            }
            if (val === 0){

                // in the event of a tie in value, we sort by player number (lowest on top)
                return ((a.innerHTML.split(/[ ']+/)[1]) - (b.innerHTML.split(/[ ']+/)[1]));
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
            image.src = "Dice" + dice[$d].getValue() + ".jpg";
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

</body>
</html>
