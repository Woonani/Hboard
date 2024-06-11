<?php

include '../model/dbconfig.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;

    include '../model/signin.php'; 

    $result = signIn( $data);

    if($result['status']){
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>  $result['message'] ]));

    } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => 'fail', 'message' => $result['message']]));
    
    }
}
