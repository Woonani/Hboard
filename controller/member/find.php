<?php
session_start();
include '../../model/dbconfig.php';
include '../../model/member/find.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST) && $_POST['mode'] == 'find_user_id') { // 아이디찾기 인증번호 요청
        $result = findUserId( $_POST);

        if($result['status'] && isset($result['data'])){
            $_SESSION['authNum'] = '123456';
            header('Content-Type: application/json');
            die( json_encode(['status' => $result['status'], 'message' =>  $result['message'], 'data' =>  $result['rowNum'] ]));
        } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => $result['status'], 'message' =>   $result['message'] ]));
        }     

    } else if (isset($_POST) && $_POST['mode'] == 'auth_num_chk_id') { // 아이디찾기 수행
        // print_r($_POST);
        if($_POST['data'] == $_SESSION['phone_auth_num']){
            $result = findUserId( $_POST);
            // print_r($result);
            if($result['status'] && isset($result['data'])){
                unset($_SESSION['authNum']);
                header('Content-Type: application/json');
                die( json_encode(['status' => true, 'message' => '인증성공', 'data' =>  $result['data']['user_id'] ]));
            } else {
                header('Content-Type: application/json');
                die( json_encode(['status' => false, 'message' => '조회실패' ]));
                }         
        } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => false, 'message' => '인증실패' ]));
        }
        
    } else if (isset($_POST) && $_POST['mode'] == 'find_user_pw') { // 비번찾기 인증번호 요청
        $result = findUserPW( $_POST);

        if($result['status'] && isset($result['data'])){
            $_SESSION['authNum'] = '123456';
            header('Content-Type: application/json');
            die( json_encode(['status' => $result['status'], 'message' =>  $result['message'], 'data' =>  $result['rowNum'] ]));
        } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => $result['status'], 'message' =>   $result['message'] ]));
        }     

    } else if (isset($_POST) && $_POST['mode'] == 'auth_num_chk_pw') { // 비번찾기 수행

        if($_POST['data'] == $_SESSION['phone_auth_num']){

            $result = findUserPW( $_POST);

            if($result['status'] && isset($result['data'])){
                unset($_SESSION['authNum']);
                header('Content-Type: application/json');
                die( json_encode(['status' => true, 'message' => '인증성공', 'data' =>  $result['data']['password'] ]));
            } else {
                header('Content-Type: application/json');
                die( json_encode(['status' => false, 'message' => '조회실패' ]));
                }         
        } else {
            header('Content-Type: application/json');
            die( json_encode(['status' => false, 'message' => '인증실패' ]));
        }
        
    }
} 