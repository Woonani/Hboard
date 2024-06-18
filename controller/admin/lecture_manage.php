<?php
session_start();

include '../../model/dbconfig.php';
include '../../model/admin/lectureInfo.php';

if(isset($_SESSION['login_user_id'])&&$_SESSION['login_user_id']=='admin') {

    if($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET['mode']) && $_GET['mode'] == 'list') {

            $result = getLectureInfo();
            
            if($result['status'] && isset($result['data'])){
                header('Content-Type: application/json');
                die( json_encode($result));
            } else {
                header('Content-Type: application/json');
                die( json_encode($result));
            } 
        } else if (isset($_GET['mode']) && $_GET['mode'] == 'view') {

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
            // print_r($_POST['level']); // 체크 후 주석

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