/**
 * Created by bentleyj on 3/9/15.
 */


describe("PigGameEngine", function() {

    var engine;
    var players;
    var dice;
    beforeEach(function() {
        engine = PigGameEngine.init(4, 2, 100);
        players = engine.getAllPlayers();
        dice = engine.getAllDice();
    });

    it("should default to turn 0", function() {
       expect(engine.getTurnNumber()).toEqual(0);
    });

    it("should default to current player number of 0", function() {
        expect(engine.getCurrentPlayerNumber()).toEqual(0);
    });

    it("should default to accumulator value of 0", function() {
        expect(engine.getAccumulator()).toEqual(0);
    });

    it("should default to four players", function() {
        expect(engine.getNumberOfPlayers()).toEqual(4);
    });

    it("should default to two dice", function() {
        expect(engine.getNumberOfDice()).toEqual(2);
    });

    it("should default to 100 points to win", function() {
        expect(engine.getAmountToWin()).toEqual(100);
    });

    it("should default to all players starting with 0 score", function() {
        var allZero = true;
        for (var i = 0; i < players.length; i++) {
            if (players[i].getValue() != 0){
                allZero = false;
            }
        }
        expect(allZero).toBeTruthy();
    });

    




});