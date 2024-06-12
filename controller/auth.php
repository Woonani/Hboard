<?php

session_start();
include '../model/login.php';
// print_r($_POST);

if(isset($_POST['mode']) && $_POST['mode'] == 'login') {

    if(isset($_POST['id'])&&isset($_POST['pw'])) {
        $result = login($_POST);
        
        if($result['status'] && $result['login']=="success"){
            $_SESSION['login_user_id'] = $result['id'];
            $_SESSION['islogin'] = 'loginned';
            $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

            header("Location: $redirect_url");
            exit();
            
        } else {
            echo "<script>alert('로그인 실패: 잘못된 사용자명 또는 비밀번호'); history.back();</script>";        
        }
        
    }else{
        echo "<script>alert('알수없는 에러: 다시 진행해 주세요.'); history.back();</script>";        

    }
} else if (isset($_GET['mode']) && $_GET['mode'] == 'logout') {
    session_destroy();
    echo "로그아웃 컨트롤러";
    header("Location: http://test.hackers.com/index.html");
    exit();
}

