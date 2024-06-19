<?php
session_start();

include '../../model/dbconfig.php';
include '../../model/member/userInfo.php';

if($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if(isset($_GET['mode']) && $_GET['mode'] == 'enter') {
        $seq = $_SESSION['login_user_seq'];
        $result = getUserInfo( $seq);

        if($result['status'] && isset($result['data'])){
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>  $result['message'], 'data' =>  $result['data'] ]));
        } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>   $result['message'] ]));
        }        
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST)) {
        $seq = $_SESSION['login_user_seq'];
        $result = setUserInfo( $seq, $_POST);

        if($result['status'] && isset($result['data'])){
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>  $result['message'], 'data' =>  $result['data'] ]));
        } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>   $result['message'] ]));
        }     
    }
} 