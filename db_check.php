<?php
// phpinfo();
$hostname = "172.16.1.66";  // 내 pc IP
// $hostname = "127.0.0.1";  // MySQL 호스트 이름
$username = "hackers";      // MySQL 사용자 이름
$password = "hackers1234!"; // MySQL 비밀번호
$database = "Hboard";          // 데이터베이스 이름
$port = "3306";          // 데이터베이스 이름



// MySQL 연결 생성
$conn = mysqli_connect($hostname, $username, $password, $database, $port); 

// Check connection
if (mysqli_connect_errno()) {
    echo $hostname."Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

try {
    $conn = mysqli_connect($hostname, $username, $password, $database, $port); 
    $result = '데이터 베이스 접속 성공';
} catch (PDOException $e) {
    $result = '접속 실패';
}

// try {
//     $pdo = new PDO('mysql:host='.$hostname.';port='.$port.';dbname='.$database.';charset=utf8', $username, $password);
//     $result = '데이터 베이스 접속 성공';
// } catch (PDOException $e) {
//     $result = '접속 실패';
// }

echo $result;

?>


