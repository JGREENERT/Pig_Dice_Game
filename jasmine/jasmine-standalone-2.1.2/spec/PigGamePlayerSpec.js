/**
 * Created by bentleyj on 3/6/15.
 */
 describe("PigGamePlayer", function() {
   var player;

   beforeEach(function() {
     player = PigGamePlayer.init("Joseph Bentley", 0);
   });

    it("should be able to set a name", function() {
        player.setName("Jesse Greenert");
        expect(player.getName()).toEqual("Jesse Greenert");
    });

    it("should be able to set an id", function () {
        player.setId(50);
        expect(player.getId()).toEqual(50);
    });

    it("should be able to get a score", function () {
        expect(player.getScore()).toEqual(0);
    });

    it ("should be able to increment a score", function() {
        player.incrementScore(10);
        expect(player.getScore()).toEqual(10);
    });

    it ("should be able to reset a score", function() {
        player.incrementScore(10);
        player.resetScore();
        expect(player.getScore()).toEqual(0);
    });

    it ("should only have one player in normal tests", function() {
        expect(PigGamePlayer.playerCount()).toEqual(1);
    });

 });

