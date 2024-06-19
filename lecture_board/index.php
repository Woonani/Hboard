<?php
session_start();

if(isset($_SESSION['login_user_id'])){
    // echo "수강후기 페이지";
    include '../include/head.php';
    include '../include/nav.php';
    include '../include/top.php';

    ?>
    <div id="container" class="container">
    <?php
    include '../include/side.php';
            
    if (isset($_GET['mode'])) {
        $fileHtml = $_GET['mode'].".html";
        $filePhp = $_GET['mode'].".php";
        if(file_exists($fileHtml)) {
            include $fileHtml;
        } else if (file_exists($filePhp)) {
            include $filePhp;

        } else{
            echo("<script>location.href='/lecture_board/index.php';</script>");
        } 
    } else {
        include "./list.html";
        // echo("<script>location.href='/index.php';</script>");
    }
    ?>
    </div>
    <?php
    include '../include/footer.php';
} else {
    include "../member/login.html";
}
?>