<?php 
// session_start();

// 로그인 유저 메뉴
if(isset($_SESSION['login_user_id'])){ //} &&  $_SESSION['islogin'] == 'loginned'){
    include "../include/header.php";
?>        
    <div id="container">    
<?php      

    if (isset($_GET['mode'])){
    
        $file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';

        if($file && file_exists($file)) { 
            include $file;            
        }           
    
    } else {
        include_once "../index2.html";
    }
?>    
    </div>    
<?php       include "../include/footer.php"; 
    
} else {
// 비로그인 유저 메뉴

    if (isset($_GET['mode'])){
        $file = isset($_GET['mode']) ? $_GET['mode'].".html" : '';

        include "../include/header.php";
            ?>        
                <div id="container">    
            <?php 
        if($file && file_exists($file)) {                 
            include $file;                
        }                        

        ?>    
        </div>    
    <?php       include "../include/footer.php"; 

} else {
    include "./login.html";
}
}
?>