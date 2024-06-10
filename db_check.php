<?php
$servername = "172.17.0.2";  // MySQL 호스트 이름
$username = "hackers";      // MySQL 사용자 이름
$password = "hackers1234!"; // MySQL 비밀번호
$dbname = "Hboard";          // 데이터베이스 이름

// MySQL 서버와 소켓 파일 위치 설정
$socket = "/var/run/mysqld/mysqld.sock";

// MySQL 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname, null, $socket);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

?>
