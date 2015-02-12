/**
 * Created by bentleyj on 2/11/15.
 */

var PigGamePlayer = (function(){

    var playerCount = 0;
    var incrementPlayerCount = function () {
        playerCount++;
    };
    var getPlayerCount = function () {
        return playerCount;
    };

    //constructor
    var init = function (name_in, id_in) {
        var name = name_in;
        var id = id_in;
        var score = 0;

        var setName = function(name_in) {
            name = name_in;
        };

        var getName = function() {
            return name;
        };

        var setId = function(id_in) {
            id = id_in;
        };

        var getId = function() {
            return id;
        };

        var getScore = function() {
            return score;
        };

        var incrementScore = function(score_in) {
            score += score_in;
        };

        var resetScore = function() {
            score = 0;
        };

        incrementPlayerCount();

        return {
            incrementScore: incrementScore,
            resetScore : resetScore,
            getScore: getScore,
            setId : setId,
            getId : getId,
            getName : getName,
            setName : setName
        }
    };//end constructor

    return {
        playerCount: getPlayerCount,
        init: init
    }
})();