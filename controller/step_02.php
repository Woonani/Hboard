<?php
// 디버깅을 위한 로그 파일 설정
ini_set('log_errors', 1);
ini_set('error_log', '/data/logs/php-error.log');
session_start();

print_r($_SERVER['REQUEST_METHOD']);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if($_POST['mode'] == 'phone_auth' && isset($_POST['data'])) { 
        // print_r($_POST['data']); // 들어옴 확인
        $_SESSION['phone_auth_num'] = '123456';
        $_SESSION['user_phone_num'] = $_POST['data'];

        // 데이터 확인 (디버깅용)
        error_log("Mode: " . $mode);
        error_log("Phone Number: " . $phoneNum);

        // echo "user_phone_num 값: ".$_SESSION['user_phone_num']; // 저장됨 확인
        header('Content-Type: application/json');
        die( json_encode(['status' => 'success', 'message' => 'Data received successfully']));
   
    } else if ($_POST['mode'] == 'auth_num_chk' && isset($_POST['data'])) { 
        print_r($_POST['data']); // 들어옴 확인
        print_r($_SESSION['phone_auth_num']); // 들어옴 확인
        
        if($_POST['data'] == $_SESSION['phone_auth_num']){
            print_r("same");
            // header('Content-Type: application/json');
            // echo json_encode(['status' => 'success', 'code' => '인증 성공']);
        } else {
            print_r("nope!!!!!!!!!!!!!!!!!!!!!!!!!!!");
            // header('Content-Type: application/json');
            // echo json_encode(['status' => 'fail', 'message' => '인증번호 불일치']);
        }

    } else {
        // 잘못된 요청 처리
        header('Content-Type: application/json', true, 400);
        echo json_encode(['status' => 'error', 'message' => '오류발생']);
    }
}