<?php
$servername = 'localhost';
$dbuser = 'hackers';
$dbpassword = 'hackers1234!';
$dbname = 'Hboard';

try {
    //pdo 내장 클래스 이용
    $db = new PDO("mysql:host={$servername};dbname={$dbname}", $dbuser, $dbpassword);

    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // prepared statement를 지원하지 않는 경우 (emulation 기능을 false로 지정해서) 데이터베이스 본 기능으로 사용할 수 있게끔 해주는 설정. 하지만 mysql을 prepared statement 기능을 기본적으로 제공하기 때문에 큰 의미는 없다.
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); //쿼리 버퍼링을 활성화 해준다. 버퍼를 이용하면 속도가 빨라짐. 같은 유형의 뭐리가 나오면 버퍼에서 바로 읽어들이기 때문에
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // pdo 객체가 에러를 처리하는 방식 정함

    // 연결확인 쿼리 실행
    $stmt = $db->query('SELECT 1');
    $result = $stmt->fetch();

    if ($result) {
        echo 'Database connection is succ';
    } else {
        echo 'fail';
    }

} catch (PDOException) {
    echo $e->getMessage();
}

