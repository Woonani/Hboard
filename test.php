<?php

session_start();
$id = $_SESSION['login_user_id'];
echo $id;
echo "<br>";
$ret = array();
echo " 빈배열 선언 : ";
print_r($ret);
echo "<br>";
include __DIR__ .'/model/dbconfig.php';
include __DIR__ .'/model/userInfo.php';


echo "<br>8-----------";

// $ret = getUserInfo($id);
echo "<br>";
echo "결과 확인 : ";
$candy = getUserInfo($conn, $id);
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>9---------------------------------------------------- : ";
print_r($candy);
// echo 
echo "<br>";
echo "<br>1----------------------------------------------------";

