<?php
session_start();

include '../model/dbconfig.php';
include '../model/userInfo.php';

if($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if(isset($_GET['mode']) && $_GET['mode'] == 'enter') {
        $id = $_SESSION['login_user_id'];
        $result = getUserInfo( $id);

        if($result['status'] && isset($result['data'])){
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>  $result['message'], 'data' =>  $result['data'] ]));
        } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' =>  $result['message']='수정 실패' ]));
        }        
    }
}