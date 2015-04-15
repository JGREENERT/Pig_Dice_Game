/**
 * Created by bentleyj on 2/11/15.
 */

var PigGameDice = (function(){
    var diceCount = 0;
    var incrementDiceCount = function () {
        diceCount++;
    };
    var getDiceCount = function () {
        return diceCount;
    };

    //constructor
    var init = function (range_in) {
        var value;
        var range = range_in;
        var seed = 1;


        /*
        Pseudo random function using a seed from stack overflow:
         http://stackoverflow.com/questions/521295/javascript-random-seeds
         */
        function random() {
            var x = Math.sin(seed++) * 10000;
            return x - Math.floor(x);
        }

        var roll = function() {
            //value = Math.floor((Math.random() * range) + 1);
            value = Math.floor((random() * range) + 1);
            return value;
        };

        var rollSpecificValue = function(value_in) {
            value = Math.floor((value_in * range) + 1);
            return value;
        };

        var setRange = function(rangeParam) {
            range = rangeParam;
        };

        var getRange = function() {
            return range;
        };

        var getValue = function() {
            return value;
        };

        var setSeed = function(seed_in) {
            seed = seed_in;
            seed = random();
        };

        var getSeed = function() {
            return seed;
        };

        incrementDiceCount();

        //everything in return are public methods of individual dice.
        return {
            rollSpecificValue : rollSpecificValue,
            roll : roll,
            setRange : setRange,
            getRange : getRange,
            getValue : getValue,
            setSeed : setSeed,
            getSeed : getSeed
        }
    };

    //public methods of PigGameDice
    return {
        diceCount: getDiceCount,
        init: init
    }
})();