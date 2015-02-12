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
<div id="PlayersDiv">
</div>

<div id="GameOutput">
    Begin rolling dice!
</div>

<div id="accumulatedValue">
    Accumulated Value:
</div>

<script type="text/javascript">

    var control = PigGameControl.init(3, 3, 100);
    var dice = control.getAllDice();
    var players = control.getAllPlayers();
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
        for (var i = 0; i < control.getNumberOfPlayers(); i++) {
            printPlayersScore(i, players[i].getScore())
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

    for (var i = 0; i < control.getNumberOfPlayers(); i++) {
        var child = document.createElement("div");
        child.id = "player" + i;
        child.innerText = "Player " + i + "'s score: ";
        document.getElementById("PlayersDiv").appendChild(child);
    }

</script>

<button style="background-color:lightgreen" onmousedown=rollDiceButtonClicked()>Roll the dice!</button>
<button style="background-color:lightgreen" onmousedown=endTurnButtonClicked()>End turn!</button>

</body>
</html>
