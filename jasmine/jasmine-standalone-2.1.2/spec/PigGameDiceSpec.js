/**
 * Created by bentleyj on 3/6/15.
 */

describe("PigGameDice", function() {
    var dice;
    var array = [0, .2, .4, .6, .8, .9];

    beforeEach(function() {
        dice = PigGameDice.init(6);
    });

    it ("should be able to set a range", function () {
       dice.setRange(20);
       expect(dice.getRange()).toEqual(20);
    });

    it("should be able to get the dice value rolled", function () {
        dice.rollSpecificValue(0);
        expect(dice.getValue()).toEqual(1);
    });

    /*
    we surround the it clause built into a function to make it a closure;
    this causes each instance of the function ran in the for loop below
    to stored values (closures!), which causes each one to run separately

    you would think you could surround the it clause itself with a for loop,
    but it has to be in a function for it to be a closure to be a unique
    run when Jasmine wants to run it.
     */
    function testDiceRolling(roll_value, value_to_generate_roll) {
        it ("should be able to roll a " + roll_value, function() {
            expect(dice.rollSpecificValue(value_to_generate_roll)).toEqual(roll_value);
        });
    }

    for (var i = 0; i < array.length; i++) {
        testDiceRolling((i+1), array[i]);
    }

});
