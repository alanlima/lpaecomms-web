<?php

namespace App\WebApiControllers;

use App\Database\ConnectionManager;

class CustomerController
{
    private $connManager;

    public function __construct() {
        global $connManager;
        $connManager = new ConnectionManager();
    }

    function newCustomer($customer) {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('INSERT INTO lpa_clients (
                                    lpa_client_firstname,
                                    lpa_client_lastname,
                                    lpa_client_address,
                                    lpa_client_phone,
                                    lpa_client_status,
                                    lpa_client_login,
                                    lpa_client_password )
                                VALUES (
                                    :firstname,
                                    :lastname,
                                    :address,
                                    :phone,
                                    :status,
                                    :login,
                                    :password
                                )');
        
        $handle->execute(array(
            ':firstname'    => $customer->firstName,
            ':lastname'     => $customer->lastName,
            ':address'      => $customer->address,
            ':phone'        => $customer->phone,
            ':status'       => 'a',
            ':login'        => $customer->login,
            ':password'     => $customer->password
        ));

        return $handle->rowCount() > 0;
    }

    function save($customer) {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('UPDATE lpa_clients SET 
                                    lpa_client_firstname = :firstname,
                                    lpa_client_lastname = :lastname,
                                    lpa_client_address = :address,
                                    lpa_client_phone = :phone
                                 WHERE lpa_client_ID = :id');
        
        $rowCount = $handle->execute(array(
            ':firstname'    => $customer->firstName,
            ':lastname'     => $customer->lastName,
            ':address'      => $customer->address,
            ':phone'        => $customer->phone,
            ':id'           => $customer->id
        ));
        
        return $handle->rowCount() > 0;        
    }

    function login($username, $password) {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('SELECT lpa_client_ID FROM lpa_clients
                                    WHERE lpa_client_login = :login
                                      AND lpa_client_password = :password ');
        
        $handle->execute(array(
            ':login' => $username,
            ':password' => $password
        ));

        return $handle->rowCount() > 0;
    }

    function info($id) {
        global $connManager;

        $link = $connManager->createLink();

        $handle = $link->prepare('SELECT lpa_client_ID,
                                         lpa_client_firstname,
                                         lpa_client_lastname,
                                         lpa_client_address,
                                         lpa_client_phone,
                                         lpa_client_login
                                 FROM lpa_clients
                                 WHERE lpa_client_ID = :id');

        $handle->execute(array( ':id' => $id ));

        if($handle->rowCount() > 0) {
            $c = $handle->fetch(\PDO::FETCH_OBJ);

            return array(
                'id' => $c->lpa_client_ID,
                'name' => $c->lpa_client_firstname." ".$c->lpa_client_lastname,
                'address' => $c->lpa_client_address,
                'phone' => $c->lpa_client_phone,
                'login' => $c->lpa_client_login
            );
        }

        return array();
    }
}