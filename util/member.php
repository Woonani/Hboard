<?php
    // SESSION 에 인증번호 고정[123456] 지정하여 매칭후 본인확인 패스
    // 세션 시작
    if(!session_id()) {
        session_start();
    }

    // 세션 변수에 고정 인증번호 저장
    $_SESSION['mobileAuthNum'] = '123456';

    print_r(['aa' => 'b']);
    print_r($_REQUEST);
    print_r($_POST);
    exit;
    // 등록된 변수 사용
    $data = $_POST["data"];
    echo "{$data} 입니다.";
    echo $data == $_SESSION." 입니다.";
    if($data == $_SESSION){
 
    }
    // 세션 변수 해제
    unset($_SESSION['mobileAuthNum']);

    echo json_encode([
        'result'    => 'success'
    ]);