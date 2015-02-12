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
<div id="PlayersDiv"></div>

<div id="GameOutput">
    Begin rolling dice!
</div>

<div id="accumulatedValue">
    Accumulated Value:
</div>

<script type="text/javascript">

    var control = PigGameControl.init(20, 2, 100);
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

        //current player is green background
        if (playerNum === control.getCurrentPlayerNumber()){
            document.getElementById("player" + playerNum).style.backgroundColor = "lightgreen";
        }
        else {
            document.getElementById("player" + playerNum).style.backgroundColor = "white";
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

    function rollDiceButtonClicked() {
        control.rollDice();
        printGameOutput();
        printScores();
        updateAccumulator();
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
        interval = setInterval(playGameAutomagically, 50);

    }

    function resetButtonClicked() {
        control.resetGame();
        printGameOutput();
        printScores();
        updateAccumulator();
        clearInterval(interval);
    }

</script>

<button style="background-color:lightgreen" onmousedown=rollDiceButtonClicked()>Roll the dice!</button>
<button style="background-color:lightgreen" onmousedown=endTurnButtonClicked()>End turn!</button>
<button onmousedown=playGameAutomagicallyInterval()>Play Game Automagically</button>
<button style="background-color:lightgreen" onmousedown=resetButtonClicked()>Reset Game!</button>
</body>
</html>
