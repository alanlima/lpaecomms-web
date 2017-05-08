<?php

namespace App\Database;

class ConnectionManager
{
    private $db = null;

    private $db_host = "localhost";
    private $db_login = "lpaecomms";
    private $db_password = "lpaecomms";
    private $db_name = "LPA_eComms";

    public function open()
    {
        global $db;
        if (!is_resource($db)) {
            /* Conection String eg.: mysqli("localhost", "lpaecomms", "letmein", "lpaecomms")
       *   - Replace the connection string tags below with your MySQL parameters
       */
      $db = new \mysqli(
        $db_host, // host
        $db_login, // user name
        $db_password, // password
        $db_name // db name
      );
            if ($db->connect_errno) {
                echo "Failed to connect to MySQL: (" .
          $db->connect_errno . ") " .
          $db->connect_error;
            }
        }
    }

    public function query($sql)
    {
        global $db;
        return $db->query($sql);
    }

    public function createLink(){
      return new \PDO(   'mysql:host=localhost;dbname=LPA_eComms;charset=utf8mb4',
                          'lpaecomms',
                          'lpaecomms',
                          array(
                              \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                              \PDO::ATTR_PERSISTENT => false
                          )
                      );
    }
}
