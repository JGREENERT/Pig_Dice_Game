"use strict";
//importScripts(PigGameEngine);

/**
 * Created by bentleyj on 2/11/15.
 */
var PigGameControl = (function () {

    var init = function (players_in, dice_in, amountToWin_in) {
        var engine = PigGameEngine.init(players_in, dice_in, amountToWin_in);

        /*****************************************************************************************
         * Public Player Methods
         *****************************************************************************************/
        var addPlayer = function (name_in, id_in) {
            engine.addPlayer(name_in, id_in);
        };

        var removePlayerByName = function (name_in) {
            engine.removePlayerByName(name_in);
        };

        var removePlayerById = function (id_in) {
            engine.removePlayerById(id_in);
        };

        var getAllPlayers = function () {
            return engine.getAllPlayers();
        };

        var getNumberOfPlayers = function () {
            return engine.getNumberOfPlayers();
        };

        var getCurrentPlayerNumber = function() {
            return engine.getCurrentPlayerNumber();
        };

        /*****************************************************************************************
         * Public Dice Methods
         *****************************************************************************************/

        var addDice = function (range_in) {
            engine.addDice(range_in);
        };

        var getAllDice = function () {
            return engine.getAllDice();
        };

        var getNumberOfDice = function() {
            return engine.getNumberOfDice();
        };

        /*****************************************************************************************
         * Public Game Logic Methods
         *****************************************************************************************/

        var rollDice = function () {
            return engine.rollDice();
        };


        var endTurn = function () {
            engine.endTurn();
        };

        var isGameOver = function () {
            return engine.isGameOver();
        };

        var resetGame = function () {
            engine.resetGame();
        };

        var newGame = function () {
            engine.newGame();
        };

        var getAccumulator = function() {
            return engine.getAccumulator();
        };

        var getMessage = function() {
            return engine.getMessage();
        };

        /*****************************************************************************************
         * Private Game Engine code to Play the game.
         *****************************************************************************************/

        return {

            //public player methods
            addPlayer: addPlayer,
            removePlayerByName: removePlayerByName,
            removePlayerById: removePlayerById,
            getNumberOfPlayers: getNumberOfPlayers,
            getAllPlayers: getAllPlayers,
            getCurrentPlayerNumber : getCurrentPlayerNumber,

            //public dice methods
            addDice: addDice,
            getNumberOfDice: getNumberOfDice,
            getAllDice: getAllDice,

            //public game methods
            endTurn: endTurn,
            rollDice: rollDice,
            getAccumulator: getAccumulator,
            isGameOver: isGameOver,
            resetGame: resetGame,
            newGame: newGame,
            getMessage : getMessage

        }
    }; // end constructor

    // public control methods
    return {
        init: init
    }
})();