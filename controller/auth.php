<?php

session_start();

include '../model/dbconfig.php';
include '../model/login.php';

if(isset($_POST['mode']) && $_POST['mode'] == 'login') {

    if(isset($_POST['id'])&&isset($_POST['pw'])) {
        $result = login($_POST);
        
        if($result['status'] && $result['login']=="success"){

            $_SESSION['login_user_seq'] = $result['data']['id'];
            $_SESSION['login_user_id'] = $result['data']['user_id'];
            $_SESSION['login_user_name'] = $result['data']['username'];
            $_SESSION['islogin'] = 'loginned';

            if($result['data']['user_id'] == 'admin'){
                header("Location: /admi/index.php");
                // header("Location: /admin/index.php");
            } else {

                $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
                header("Location: $redirect_url");
                // referer를 쓰는 이유 : 메뉴클릭 => 인덱스에서 로그인페이지 띄움 => 로그인 하면 처음 클릭했던 메뉴가 referer로 동작
            }
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
    header("Location: http://test.hackers.com/index.php");
    exit();
}

