<?php

namespace App\Database;

class ConnectionManager
{
    private $db = null;

    private $db_host = "localhost";
    private $db_login = "";
    private $db_password = "";
    private $db_name = "phpmyadmin";

    function __construct(){
        $configs = include($_SERVER['DOCUMENT_ROOT'].'/config.php');

        $this->db_host = $configs["db_host"];
        $this->db_login = $configs["db_user"];
        $this->db_password = $configs["db_pwd"];
        $this->db_name = $configs["db_name"];
    }

    // public function open()
    // {
    //     if (!is_resource($this->db)) {
    //         /* Conection String eg.: mysqli("localhost", "lpaecomms", "letmein", "lpaecomms")
    //    *   - Replace the connection string tags below with your MySQL parameters
    //    */
    //   $this->db = new \mysqli(
    //     $this->db_host, // host
    //     $this->db_login, // user name
    //     $this->db_password, // password
    //     $this->db_name // db name
    //   );
    //         if ($this->db->connect_errno) {
    //             echo "Failed to connect to MySQL: ({$this->db->connect_errno}) {$this->db->connect_error}";
    //         }
    //     }
    // }

    // public function query($sql)
    // {
    //     return $this->db->query($sql);
    // }

    public function createLink(){
      return new \PDO(   "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8mb4",
                          $this->db_login,
                          $this->db_password,
                          array(
                              \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                              \PDO::ATTR_PERSISTENT => false
                          )
                      );
    }
}
