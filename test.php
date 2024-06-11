<?php
echo 'db check and test';
echo '<br>';
echo '<br>'."connection : ";

// db연결

// include 'db_check.php'; 
include 'model/dbconfig.php'; // 자바의 import 처럼 
include 'model/signin.php';

// 아이디 중복 테스트

// $id = 'nani'; //아이디가 중복됩니다. 출력
$id = 'admin'; //사용할 수 있는 아이디입니다. 출력



echo '<br>-----------------------------------------------------------------<br>';

$result = checkId($id);
echo $id." : ";
print_r($result);

// $stmt = mysqli_prepare($conn, "SELECT user_id FROM Users WHERE user_id = ?");
// if (!$stmt) {
//     die("MySQL prepare error: " . mysqli_error($conn));
// }

// mysqli_stmt_bind_param($stmt, "s", $id);
// $execute_result = mysqli_stmt_execute($stmt);

// if (!$execute_result) {
//     die("MySQL execute error: " . mysqli_stmt_error($stmt)); 
// }

// // 결과 가져오기
// $queryResult = mysqli_stmt_get_result($stmt);
// echo "\n" ;
// print_r($queryResult);

// if (!$queryResult) {
//     die("MySQL get_result error: " . mysqli_error($conn));
// }

// // 조회한 행의 개수
// $numRow = mysqli_num_rows($queryResult);

// echo "\nNumber of rows: " . $numRow;
// echo "*";
