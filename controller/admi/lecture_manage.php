<?php
session_start();

include '../../model/dbconfig.php';
include '../../model/admi/lectureInfo.php';

if(isset($_SESSION['login_user_id'])&&$_SESSION['login_user_id']=='admin') {

    if($_SERVER["REQUEST_METHOD"] == "GET") {
        $result = getLectureInfo();

        if($result['status'] && isset($result['data'])){
            header('Content-Type: application/json');
            die( json_encode($result));
        } else {
            header('Content-Type: application/json');
            die( json_encode($result));
        } 
    }
}

?>