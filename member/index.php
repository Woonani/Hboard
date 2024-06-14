<?php 
session_start();

// 로그인 유저 메뉴
if(isset($_SESSION['login_user_id'])){ //} &&  $_SESSION['islogin'] == 'loginned'){
    // include "../include/header.php";
    include '../include/head.php';
    include '../include/nav.php';
    include '../include/top.php';

    if (isset($_GET['mode'])){
    
        $file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';

        if($file && file_exists($file)) { 
            include $file;            
        } else {
            include_once "../index.php"; 
        }           
    
    } else {
        include_once "../index.php"; 
    }
     include "../include/footer.php"; 
    
} else {
// 비로그인 유저 메뉴

    if (isset($_GET['mode'])){
        $file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';

        // include "../include/header.php";
        include '../include/head.php';
        include '../include/nav.php';
        include '../include/top.php';

        if($file && file_exists($file)) {                 
            include $file;                
        }                        

       include "../include/footer.php"; 

    } else {
        include "./login.html";
    }
}
?>