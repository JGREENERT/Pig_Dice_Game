/**
 * Created by bentleyj on 2/11/15.
 */

var PigGameDice = (function(){
    var diceCount = 0;
    var incrementDiceCount = function () {
        diceCount ++;
    };
    var getDiceCount = function () {
        return diceCount;
    };

    //constructor
    var init = function (range_in) {
        var value;
        var range = range_in;
        var roll = function() {
            value = Math.floor((Math.random() * range) + 1);
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

        incrementDiceCount();

        //everything in return is public
        return {
            roll : roll,
            setRange : setRange,
            getRange : getRange,
            getValue : getValue
        }
    };

    return {
        diceCount: getDiceCount,
        init: init
    }
})();