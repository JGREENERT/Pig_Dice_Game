/**
 * Created by bentleyj on 2/11/15.
 */
"use strict";
//importScripts(PigGameDice, PigGamePlayer);

var PigGameEngine = (function() {


    var init = function(players_in, dice_in, amountToWin_in) {

        //private variables
        var gameOver = -1;
        var players = [];
        var dice = [];
        var turnNumber = 0;
        var currentPlayer = 0;
        var amountToWin = amountToWin_in;
        var accumulator = 0;
        var message = "Welcome to our PigGame!";

        /*****************************************************************************************
         * Public Player Methods
         *****************************************************************************************/
        var addPlayer = function(name_in, id_in) {
            var num = PigGamePlayer.playerCount();
            players.push(PigGamePlayer.init(name_in, id_in));

            //players[num] = PigGamePlayer.init(name_in, id_in);      //don't do this, null pointer
            console.log("Added a new player in game engine!");
            message = "Player " + name_in + " added to the game!";
        };

        var removePlayerByName = function(name_in) {

        };

        var removePlayerById = function(id_in) {

        };

        var getAllPlayers = function() {
            return players;
        };

        var getNumberOfPlayers = function() {
            return PigGamePlayer.playerCount();
        };

        var getCurrentPlayerNumber = function() {
            return currentPlayer;
        };


        /*****************************************************************************************
         * Public Dice Methods
         *****************************************************************************************/

        var addDice = function(range_in) {
            var numberOfDice = PigGameDice.diceCount();
            dice.push(PigGameDice.init(range_in));
            //dice[numberOfDice] = PigGameDice.init(range_in);          // don't do this, null pointer.
            console.log("Added a new dice in game engine!");
            message = "Added a new dice in the game engine";
        };

        var getAllDice = function() {
            return dice;
        };

        /*****************************************************************************************
         * Public Game Logic Methods
         *****************************************************************************************/

        var rollDice = function() {

            if (isGameOver() != -1){
                message = players[gameOver].getName() + " has already won!";
                return;
            }

            console.log("Rolling dice");
            var sum = rollAllDice();

            if (sum == 2) {
                //reset to zero occurred
                players[currentPlayer].resetScore();
                accumulator = 0;
                sum = 0;
                endTurn();
                return sum;
            }
            if (sum == 0){
                //user rolled a 1
                accumulator = 0;
                endTurn();
            }
            else{
                //add to an accumulator
                accumulator += sum;
            }
            return sum;
        };

        var rollSpecificValues = function(roll_value) {

            if (isGameOver() != -1){
                message = players[gameOver].getName() + " has already won!";
                return;
            }

            console.log("Rolling dice");
            var sum = roll_value;

            if (sum == 2) {
                //reset to zero occurred
                players[currentPlayer].resetScore();
                accumulator = 0;
                sum = 0;
                endTurn();
                return sum;
            }
            if (sum == 0){
                //user rolled a 1
                accumulator = 0;
                endTurn();
            }
            else{
                //add to an accumulator
                accumulator += sum;
            }

            return sum;
        };


        var endTurn = function() {
            console.log("Ending turn");
            if (isGameOver() != -1){
                message = players[gameOver].getName() + " has already won!";
                return;
            }

            //sketchy spaghetti
            if (message.indexOf(players[currentPlayer].getName()) < 0)
                message = players[currentPlayer].getName()  + " donated his turn! ";

            message += " Incrementing player score by: " + accumulator;
            players[currentPlayer].incrementScore(accumulator);

            // if player score is above the amount to win
            if (players[currentPlayer].getScore() >= amountToWin) {
                gameOver = currentPlayer;
                message = "Yay, Player " + currentPlayer + " has won!";
            }
            else {
                accumulator = 0;
                turnNumber++;
                currentPlayer = turnNumber % PigGamePlayer.playerCount();
            }
        };

        var isGameOver = function() {
            return gameOver;
        };

        var resetGame = function() {
            for (var i = 0; i < PigGamePlayer.playerCount(); i++){
                players[i].resetScore();
            }
            turnNumber = 0;
            currentPlayer = 0;
            accumulator = 0;
            message = "New Game Started! " + players[gameOver].getName() +  " won the last game!";
            gameOver = -1;
        };

        var newGame = function() {

        };

        var getNumberOfDice = function() {
            return PigGameDice.diceCount();
        };

        var getAccumulator = function() {
            return accumulator;
        };

        var getMessage = function() {
            return message;
        };

        var getTurnNumber = function() {
            return turnNumber;
        };

        var getAmountToWin = function() {
            return amountToWin;
        };

        /*****************************************************************************************
         * Private Game Engine code to Play the game.
         *****************************************************************************************/

        var rollAllDice = function() {

            message = players[currentPlayer].getName()  + " rolled: ";

            //roll all dice
            for (var y = 0; y < PigGameDice.diceCount(); y++) {
                dice[y].roll();
                if (y === PigGameDice.diceCount() - 1)
                    message += dice[y].getValue();
                else
                    message += dice[y].getValue() + " + ";
            }

            // check if resetToZero roll occurred
            if (checkResetToZeroRoll()) {
                message = players[currentPlayer].getName()  + " crapped out!";
                return 2;
            }

            //get sum
            var sum = 0;
            var foundAOne = false;
            for (var i = 0; i < PigGameDice.diceCount(); i++) {

                //return 0 roll
                if (dice[i].getValue() == 1)
                    foundAOne = true;
                sum += dice[i].getValue();
            }
            message += " = " + sum;
            if (foundAOne)
                return 0;
            return sum;
        };

        var checkResetToZeroRoll = function() {
            for (var i = 0; i < PigGameDice.diceCount(); i++) {
                if (dice[i].getValue() != 1)
                    return false;
            }
            return true;
        };

        
        for (var p = 0; p < players_in.length; p++){
            addPlayer(players_in[p], p);
        }

        for (var d = 0; d < dice_in; d++){
            addDice(6);
        }


        return {
            //public player methods
            addPlayer : addPlayer,
            removePlayerByName : removePlayerByName,
            removePlayerById : removePlayerById,
            getNumberOfPlayers : getNumberOfPlayers,
            getAllPlayers : getAllPlayers,
            getCurrentPlayerNumber : getCurrentPlayerNumber,

            //public dice methods
            addDice : addDice,
            getNumberOfDice : getNumberOfDice,
            getAllDice : getAllDice,

            //public game methods
            getAmountToWin: getAmountToWin,
            endTurn : endTurn,
            getTurnNumber: getTurnNumber,
            rollDice : rollDice,
            rollSpecificValues : rollSpecificValues,
            getAccumulator: getAccumulator,
            isGameOver : isGameOver,
            resetGame : resetGame,
            newGame : newGame,
            getMessage : getMessage
        }
    }; // end constructor

    // public engine methods
    return {
        init : init
    }

})();