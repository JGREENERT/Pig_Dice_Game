<?php
/**
 * Created by IntelliJ IDEA.
 * User: bentleyj
 * Date: 3/31/15
 * Time: 1:47 PM
 */

class Room {
    private $name;
    private $numOfPlayers;
    private $numOfDice;
    private $scoreToWin;
    private $ownerName;
    private $users = array();

    function __construct($name, $numOfPlayers, $numOfDice, $scoreToWin, $ownerName) {
        $this->name = $name;
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

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->$name;
    }

    public function setNumOfPlayers($numOfPlayers) {
        $this->numOfPlayers = $numOfPlayers;
    }

    public function getNumOfPlayers($numOfPlayers) {
        return $this->numOfPlayers;
    }

    public function setNumOfDice($numOfDice) {
        $this->numOfDice = $numOfDice;
    }

    public function getNumOfDice($numOfDice) {
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