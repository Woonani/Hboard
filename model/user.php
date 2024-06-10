<?php

function checkId($id) {
    $result = array();

    require_once $_SERVER['DOCUMENT_ROOT'].'/model/dbconfig.php';
    // include 'dbconfig.php';

    if(mysqli_connect_errno()){ //db연결 실패
        $result['status'] = false;
        $result['message'] = "db연결 실패";
  
    }else { //db 연결성공
        $idCheckQuery = "SELECT user_id FROM user WHERE user_id = '".$id."'"; // 입력한 id랑 같은 id 조회
        $queryResult = mysqli_query($connect, $idCheckQuery); // 쿼리 실행
        $numRow = mysqli_num_rows($queryResult); //조회한 행의 개수 
  
        if($numRow > 0){ // 같은 id 있음
          // $result = '이미 사용중인 id 입니다';
          $result['status'] = false;
          $result['message'] = "이미 사용중인 id 입니다.";
        }else{ //같은 id 없음
          $result['status'] = true;
          $result['message'] = "사용 가능한 id 입니다.";
        }
  
        mysqli_close($connect); // db 연결 종료
    }

    return $result;

}


// // User Class file
// class User {
//     // 멤버변수, 프로퍼티
//     private $conn; // db 연결 객체를 받아와야 함

//     // 생성자(클래스 생성시 무조건 호출)
//     public function __construct($db) { // db연결객체인 pdo 인스턴스를 받는 작업을 함
//         $this->conn = $db;
//     }

//     // 아이디 중복체크용 멤버 함수, 메서드 
//     public function id_exists($id) { // 중복체크할 id를 파라미터로 받아서
//         $sql = "SELECT * FROM User WHERE user_id=:id"; 
//         // $sql = "SELECT * FROM member WHERE id=?";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bindParam(':id', $id);
//         // $stmt ->bindParam(1, $id); // 이런 방식도 있음
//         $stmt->execute();

//         return $stmt->rowCount() ? true : false; // row를 숫자로 받아옴
//     }

//     public function email_exists($email) {
//         $sql = "SELECT * FROM User WHERE email=:email";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bindParam(':email',$email);
//         $stmt->execute();

//         return $stmt->rowCount() ? true : false;
//     }
// }