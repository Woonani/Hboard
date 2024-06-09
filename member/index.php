<?php include "../include/header.php" ?>

<div id="container">
<?php
$file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';

if($file && file_exists($file)) {
    include $file;
} else {
    // 아래코드는 무한 실행..
    // echo "<script>window.location.href = 'index.php';</script>";
    // exit; 
    include_once "../index.html";
}                
?>
</div>

<?php include "../include/footer.php" ?>
