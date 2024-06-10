<?php
echo 'hello';
echo '<br>';

// db연결
include '../model/dbconfig.php'; // 자바의 import 처럼 쓰기도 함
include '../model/user.php';

// 아이디 중복 테스트

// $id = 'nani'; //아이디가 중복됩니다. 출력
$id = 'admin'; //사용할 수 있는 아이디입니다. 출력
$email = 's';

$mem = new User($db);
print_r($mem);
echo '<br>';

// 결과 : Object ( [conn:User:private] => PDO Object ( ) ) 출력
//                [멤버변수명:클래스명:멤버변수접근제한자]
// 의미 : User 클래스 인스턴스 $mem가 private 속성 conn을 가지고 있으며, 이 속성은 PDO 객체를 가리키고 있다는 것을 의미

if($mem->id_exists($id)) {
    echo "아이디가 중복됩니다.";
} else {
    echo "사용할 수 있는 아이디입니다.";
}
// if($mem->email_exists($email)) {
//     echo "이메일이 중복됩니다.";
// } else {
//     echo "사용할 수 있는 이메일입니다.";
// }
