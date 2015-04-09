#!/usr/bin/env php
<?php

require_once('./websockets.php');

class echoServer extends WebSocketServer {
  //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.

 private $engines = array();

  protected function process ($user, $message)
  {
      /*
      switch ($message) {
          case "create room":
              echo "create room";
              break;
          case "join room":
              echo "join room";
              break;
          default:
              echo "default case";
      }
      */

      foreach ($this->users as $user2) {
          $this->send($user2, $message);
      }

      //$this->send($user, $message);

      /*
       *
       * if ($message == Play New Game Against [Users])
       *     create new game
       *     link users/sockets to engine
       *     send start of engine down all necessary sockets indicating game update
       *
       * if ($message == end turn)
       *     end turn in engine
       *     send result down all necessary sockets indicating game update
       *
       * if ($message == roll dice)
       *     roll dice in engine
       *     send result down all necessary sockets indicating game update
       *
       */
  }
  
  protected function connected ($user) {
    // Do nothing: This is just an echo server, there's no need to track the user.
    // However, if we did care about the users, we would probably have a cookie to
    // parse at this step, would be looking them up in permanent storage, etc.

      /*
       * Parse cookie (session stuff)
       */

  }
  
  protected function closed ($user) {
    // Do nothing: This is where cleanup would go, in case the user had any sort of
    // open files or other objects associated with them.  This runs after the socket 
    // has been closed, so there is no need to clean up the socket itself here.

      /*
       * Delete engine potentially
       */
  }
}

$echo = new echoServer("0.0.0.0","9000");

try {
  $echo->run();
}
catch (Exception $e) {
  $echo->stdout($e->getMessage());
}
