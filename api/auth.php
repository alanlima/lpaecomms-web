<?php


    // ini_set('display_errors', 'On');
    // ini_set('html_errors', 0);

    // error_reporting(-1);

    require('../app-lib.php');

    use App\Database\ConnectionManager;
    use App\Utils\Security;

    $connManager = new ConnectionManager;
    $security = new Security;
    
    $login = isset($_POST['UserName']) ? $_POST['UserName'] : '';
    $pass = isset($_POST['Password']) ? $_POST['Password'] : '';

    $link = $connManager->createLink();

    $handle = $link->prepare("SELECT lpa_user_ID, lpa_user_username, lpa_user_password, lpa_user_firstname, lpa_user_lastname
                              FROM lpa_users
                              WHERE lpa_user_username = :user
                              LIMIT 1");
    $handle->execute(array(':user' => $login));



    try {
      ob_clean();
    } catch(Exception $e) {

    }
    
    header('Content-type: application/json');

    if($handle->rowCount() > 0) {

      $u = $handle->fetch(\PDO::FETCH_OBJ);

      $userPassword = $u->lpa_user_password;

      if($security->IsEquals($pass, $userPassword)) {
        $_SESSION['authUser'] = $u->lpa_user_ID;
        $_SESSION['authUserFullName'] = $u->lpa_user_firstname . " " . $u->lpa_user_lastname;
        
        echo json_encode(array(
            'success' => true,
            'message' => 'User successfully authenticated.'
        ));
  
        exit;
      }
    }

    echo json_encode(array(
            'success' => false,
            'message' => 'User/Password invalid.'
        ));
?>
