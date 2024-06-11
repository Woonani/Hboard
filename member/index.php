<?php include "../include/header.php" ?>

<div id="container">
<?php

if (isset($_GET['mode'])) {
    if ($_GET['mode'] === 'regist') {
        // 회원가입 폼 표시
        include 'regist.php';
    } else{
        $file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';
        include $file;
    }
} else {
    echo "잘못된 접근입니다.";
}


// $file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';

// if($file && file_exists($file)) {
//     include $file;
// } else {
//     // 아래코드는 무한 실행..
//     // echo "<script>window.location.href = 'index.php';</script>";
//     // exit; 
//     include_once "../index.html";
// }                
// ?>
</div>

<?php include "../include/footer.php" ?>
