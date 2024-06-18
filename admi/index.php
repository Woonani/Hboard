<?php
session_start();

if(isset($_SESSION['login_user_id']) == 'admin'){ // 주소치고 들어오는것을 막기위함
// session_start();
include '../include/head.php';
include '../include/nav.php';
include '../include/top.php';

    if(isset($_GET['mode'])){
        $file = $_GET['mode'].".html";
        if(file_exists($file)) {
            include $file;
        } else {
            echo("<script>location.href='/admin/index.php';</script>");
        } 
    } else {
        include "./lecture_manage.html";
    }
include "../include/footer.php"; 

} else {
    echo("<script>");
    echo("alert('[관리자페이지] \n잘못된 접근입니다. \n관리자 계정으로 로그인해주세요.');");
    // echo("location.href='/';");
    echo("</script>");

    include "../member/login.html";
}

?>