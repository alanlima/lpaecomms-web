<?php

namespace App\Database;

class ConnectionManager{
  private $db = null;

  function open(){
    global $db;
    if(!is_resource($db)) {
      /* Conection String eg.: mysqli("localhost", "lpaecomms", "letmein", "lpaecomms")
       *   - Replace the connection string tags below with your MySQL parameters
       */
      $db = new \mysqli(
        "localhost", // host
        "lpaecomms", // user name
        "lpaecomms", // password
        "LPA_eComms" // db name
      );
      if ($db->connect_errno) {
        echo "Failed to connect to MySQL: (" .
          $db->connect_errno . ") " .
          $db->connect_error;
      }
    }
  }

  function query($sql){
    global $db;
    return $db->query($sql);
  }
}

?>
