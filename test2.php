


<?php
session_start();

echo  $_SERVER['SERVER_NAME']."<br>";
echo  $_SERVER['HTTP_ACCEPT']."<br>";
echo  $_SERVER['REMOTE_ADDR']."<br>";
echo  $_SERVER['HTTP_REFERER']."<br>";
echo "-------\n";
// unset($_SESSION['login_user_id']);
$_SESSION['login_user_id']="";
echo isset($_SESSION['login_user_id'])."<- 값 \n";

// 로그인 전
if(!isset($_SESSION['login_user_id'])) {		
											
    ?>					
    <a href="http://test.hackers.com/member/login.html">로그인</a>
    <a href="http://test.hackers.com/member/index.php?mode=step_01">회원가입</a>
    <a href="#">상담/고객센터</a>
    <?php		
        } else {
        // 로그인 후
    ?>				
    <a href="http://test.hackers.com/controller/auth.php?mode=logout">로그아웃</a>
    <a href="#">내정보</a>
    <a href="#">상담/고객센터</a>
    <?php 
    }





echo '<br>-----------------------------------------------------------------<br>';
