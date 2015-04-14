<?php
/**
 * Created by IntelliJ IDEA.
 * User: bentleyj
 * Date: 3/31/15
 * Time: 1:47 PM
 */

class Room {
    private $numOfPlayers;
    private $numOfDice;
    private $scoreToWin;
    private $ownerName;
    private $users = array();

    function __construct($numOfPlayers, $scoreToWin, $numOfDice, $ownerName) {
        $this->numOfPlayers = $numOfPlayers;
        $this->numOfDice = $numOfDice;
        $this->scoreToWin = $scoreToWin;
        $this->ownerName = $ownerName;
    }


    public function addUser($user) {
        $this->users[$user->id] = $user;
    }

    public function removeUser($user) {
        unset($this->users[$user->id]);
    }

    public function getUsers() {
        return $this->users;
    }

    public function setNumOfPlayers($numOfPlayers) {
        $this->numOfPlayers = $numOfPlayers;
    }

    public function getNumOfPlayers() {
        return $this->numOfPlayers;
    }

    public function setNumOfDice($numOfDice) {
        $this->numOfDice = $numOfDice;
    }

    public function getNumOfDice() {
        return $this->numOfDice;
    }

    public function setScoreToWin($scoreToWin) {
        $this->scoreToWin = $scoreToWin;
    }

    public function getScoreToWin() {
        return $this->scoreToWin;
    }

    public function setOwnerName($ownerName) {
        $this->ownerName = $ownerName;
    }

    public function getOwnerName() {
        return $this->ownerName;
    }
} 