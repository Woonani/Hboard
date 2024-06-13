<?php

include '../model/dbconfig.php'; 
include '../model/signin.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;


    $result = signIn( $data);

    if($result['status']){
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>  $result['message'] ]));

    } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => 'fail', 'message' => $result['message']]));
    
    }
}
