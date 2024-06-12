<?php
$dbhost = "172.16.1.66";  // 내 pc IP
// $hostname = "127.0.0.1";  // MySQL 호스트 이름
$dbusername = "hackers";      // MySQL 사용자 이름
$dbpassword = "hackers1234!"; // MySQL 비밀번호
$dbname = "Hboard";          // 데이터베이스 이름
$dbport = "3306";          // 데이터베이스 이름

// MySQL 연결 생성
$conn = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport); 

// Check connection
if (mysqli_connect_errno()) {
    echo $hostname."Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// try {
//     $pdo = new PDO('mysql:host='.$hostname.';port='.$port.';dbname='.$database.';charset=utf8', $username, $password);
//     $result = '데이터 베이스 접속 성공';
// } catch (PDOException $e) {
//     $result = '접속 실패';
// }

?>


