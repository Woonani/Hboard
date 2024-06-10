<?php
session_start();
// include $_SERVER['DOCUMENT_ROOT'] . 'model/dbconfig.php'; // ~~T'] . '/model/dbconfig.php'; 오류남
// include $_SERVER['DOCUMENT_ROOT'] . 'model/dbconfig.php';
include 'model/dbconfig.php'; //'../model/dbconfig.php'; 는 오류남
include 'model/user.php'; 




if($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    die( json_encode(['status' => 'success', 'data' => $_SESSION['user_phone_num']]));

}else if($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if($_POST['mode'] == 'id_dup_chk') { 
        // 아이디 중복 체크
        $user_id = $_POST['data'];
        
        // 문제 시작.....
        // $user = new User($db);
        $result = array();
        $result = checkId( $user_id);

        
        // if($user->id_exists($user_id)){
            header('Content-Type: application/json');
            die( json_encode(['status' => 'success', 'message' => $_POST['data'].'는 사용가능한 아이디입니다.']));

        // }else{
        //     die( json_encode(['status' => 'fail', 'message' => '이미 사용중인 아이디입니다.']));

        // }

        return;

    


    } else if($_POST['mode'] == 'sign_in') { 
        // 회원가입 진행
       
        
        header('Content-Type: application/json');
        die( json_encode(['status' => 'success', 'message' => '가입완료']));
        return;
    }
}
