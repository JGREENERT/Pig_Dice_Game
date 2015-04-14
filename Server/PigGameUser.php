<?php
/**
 * Created by IntelliJ IDEA.
 * User: bentleyj
 * Date: 4/14/15
 * Time: 12:11 PM
 */

namespace Server;
require_once('./users.php');
class PigGameUser extends WebSocketUser{

    private $name;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
} 