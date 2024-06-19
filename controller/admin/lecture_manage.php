<?php
session_start();

include '../../model/dbconfig.php';
include '../../model/admin/lectureInfo.php';

if(isset($_SESSION['login_user_id'])&&$_SESSION['login_user_id']=='admin') {

    if($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['mode']) && $_GET['mode'] == 'view') {

            $result = getLectureInfoOne($_GET['lec_seq']);
            
            if($result['status'] && isset($result['data'])){
                header('Content-Type: application/json');
                die( json_encode($result));
            } else {
                header('Content-Type: application/json');
                die( json_encode($result));
            } 
        } else if (isset($_GET['mode']) && $_GET['mode'] == 'delete') {

            $result = deleteLectureInfo($_GET['lec_seq']);
            
            if($result['status']){
                header('Content-Type: application/json');
                die( json_encode($result));
            } else {
                header('Content-Type: application/json');
                die( json_encode($result));
            } 
        }else{
            $result = array();
            $result['status'] = false;
            $result['message'] = "잘못된 요청";
            die( json_encode($result));
        }
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['mode']) && $_POST['mode'] == 'regist') {

            $result = createUserInfo($_POST);
            
            if($result['status']){
                header('Content-Type: application/json');
                die( json_encode($result));
            } else {
                header('Content-Type: application/json');
                die( json_encode($result));
            } 
        } else if(isset($_POST['mode']) && $_POST['mode'] == 'modify') {

            $result = updateUserInfo($_POST);
            
            if($result['status'] ){
                header('Content-Type: application/json');
                die( json_encode($result));
            } else {
                header('Content-Type: application/json');
                die( json_encode($result));
            } 
        } 
    }
}

?>