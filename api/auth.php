<?php
    require('../app-lib.php');

    use App\Database\ConnectionManager;

    ob_clean();

    $connManager = new ConnectionManager;

    $login = isset($_POST['UserName']) ? $_POST['UserName'] : '';
    $pass = isset($_POST['Password']) ? $_POST['Password'] : '';

    $connManager->open();

     $query =
      "SELECT
        lpa_user_ID,
        lpa_user_username,
        lpa_user_password
      FROM
        lpa_users
      WHERE
        lpa_user_username = '$login'
      AND
        lpa_user_password = '$pass'
      LIMIT 1";

    $result = $connManager->query($query);

    $row = $result->fetch_assoc();

    header('Content-type: application/json');

    if(!is_null($row) && $row['lpa_user_username'] == $login) {
      if($row['lpa_user_password'] == $pass) {
        $_SESSION['authUser'] = $row['lpa_user_ID'];

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