<?php

//First, define your auto-load function.
function MyAutoload($className){
    $className=str_replace("\\","/",$className);
    $className=str_replace("App/","",$className);
    $class="{$className}.php";
    include_once($class);
}

// Next, register it with PHP.
spl_autoload_register('MyAutoload');

/**
 * Set the global time zone
 *   - for Brisbane Australia (GMT +10)
 */
date_default_timezone_set('Australia/Queensland');
setlocale(LC_MONETARY, 'en_US');

/**
 * Global variables
 */

// Database instance variable
// $db = null;
$displayName = "";

use App\Database\ConnectionManager;


// Start the session
session_name("lpaecomms");
session_start();

isset($_SESSION["authUser"])?
  $authUser = $_SESSION["authUser"] :
  $authUser = "";

if (isset($authChk) == true) {
    if ($authUser) {
        $displayName = $_SESSION["authUserFullName"];
    } else {
        header("location: login.php");
    }
}

/**
 * System Logout check
 *
 *  - Check if the logout button has been clicked, if so kill session.
 */
if (isset($_REQUEST['killses']) == "true") {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
    }
    session_destroy();
    header("location: login.php");
}

/**
* Customer Error Handler
**/

// ----------------------------------------------------------------------------------------------------
// - Display Errors
// ----------------------------------------------------------------------------------------------------
// ini_set('display_errors', 'On');
// ini_set('html_errors', 0);

// ----------------------------------------------------------------------------------------------------
// - Error Reporting
// ----------------------------------------------------------------------------------------------------
error_reporting(-1);

// ----------------------------------------------------------------------------------------------------
// - Shutdown Handler
// ----------------------------------------------------------------------------------------------------
function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('customErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    if(!file_exists(__DIR__.'/log')) {
        mkdir(__DIR__.'/log', 0777, true);
    }

    $logFile = fopen(__DIR__.'/log/log.txt', 'a+');
    $currentTime = date("Y-m-d H:i:s");

    $logContent = "==> {$currentTime} - ({$errno}) {$errstr} on {$errfile} at line {$errline}".PHP_EOL;

    fwrite($logFile, $logContent);

    fclose($logFile);

    echo "Fail to execute the operation. Try again.";

    return true;
}

/**
 *  Build the page header function
 */
function build_header()
{
    global $displayName;

    include 'header.php';
}

/**
 * Build the Navigation block
 */
function build_navBlock()
{
    ?>
    <div id="navBlock">
      <div id="navHeader">MAIN MENU</div>
      <div class="navItem" onclick="navMan('index.php')">HOME</div>
      <div class="navItem" onclick="navMan('stock.php')">STOCK</div>
      <div class="navItem" onclick="navMan('sales.php')">SALES</div>
      <div class="menuSep"></div>
      <div class="navItem" onclick="navMan('login.php?killses=true')">Logout</div>
    </div>
<?php

}

/**
 * Create an ID
 * - Create a unique id.
 *
 * @param string $prefix
 * @param int $length
 * @param int $strength
 * @return string
 */
function gen_ID($prefix='', $length=10, $strength=0)
{
    $final_id='';
    for ($i=0;$i< $length;$i++) {
        $final_id .= mt_rand(0, 9);
    }
    if ($strength == 1) {
        $final_id = mt_rand(100, 999).$final_id;
    }
    if ($strength == 2) {
        $final_id = mt_rand(10000, 99999).$final_id;
    }
    if ($strength == 4) {
        $final_id = mt_rand(1000000, 9999999).$final_id;
    }
    return $prefix.$final_id;
}

/**
 *  Build the page footer function
 */
function build_footer()
{
    include 'footer.php';
}

function allowGetOnly() {
    if($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("HTTP/1.0 405 Method Not Allowed"); 
        exit();
    }
}

function allowPostOnly() {
    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        header("HTTP/1.0 200 Ok"); 
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'
        && $_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
        header("HTTP/1.0 405 Method Not Allowed"); 
        exit();
    }
}

function allowCORS(){
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE,OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
}