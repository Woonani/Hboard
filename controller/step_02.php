<?php
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if($_POST['mode'] == 'phone_auth' && isset($_POST['data'])) { 
        $_SESSION['phone_auth_num'] = '123456';
        $_SESSION['user_phone_num'] = $_POST['data'];

        // echo "user_phone_num 값: ".$_SESSION['user_phone_num']; // 저장됨 확인
        header('Content-Type: application/json');
        die( json_encode(['status' => 'success', 'message' => 'Data received successfully']));
   
    } else if ($_POST['mode'] == 'auth_num_chk' && isset($_POST['data'])) { 
        
        if($_POST['data'] == $_SESSION['phone_auth_num']){
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'message' => '인증 성공']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'fail', 'message' => '인증번호 불일치']);
        }

    } else {
        // 잘못된 요청 처리
        header('Content-Type: application/json', true, 400);
        echo json_encode(['status' => 'error', 'message' => '오류발생']);
    }
}