<?php

function checkId($id) {

    $result = array();
    include __DIR__ .'/dbconfig.php'; // /경로문제!!!


    if(mysqli_connect_errno()){ //db연결 실패
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
  
    }else { //db 연결성공

      $stmt = mysqli_prepare($conn, "SELECT user_id FROM Users WHERE user_id = ?");
      mysqli_stmt_bind_param($stmt, "s", $id);
      mysqli_stmt_execute($stmt);

      $queryResult = mysqli_stmt_get_result($stmt);

        // 조회한 행의 개수
      $numRow = mysqli_num_rows($queryResult);

      

        $result['status'] = true;

        if($numRow > 0){ // 같은 id 있음
          $result['dub_chk'] = false;
          $result['numRow'] = $numRow;
          $result['message'] = "이미 사용중인 id 입니다.";
        }else{ //같은 id 없음
          $result['dub_chk'] = true;
          $result['numRow'] = $numRow;
          $result['message'] = "사용 가능한 id 입니다.";
        }
  
        // mysqli_close($connect); // db 연결 종료
        // prepared statement 종료
        mysqli_stmt_close($stmt);
        // MySQL 연결 종료
        mysqli_close($conn); 
        
    }

    return $result;

}


function signIn($data) {

  $result = array();

  $name = $data['name'];
  $id = $data['id'];
  $pw = hash("sha256", $data['pw']);
  $email = $data['email'];
  $phone = $data['phone'];
  $tel = $data['tel'];
  $postal_code = $data['postal_code'];
  $address = $data['address'];
  $address_detail = $data['address_detail'];
  $sms_opt = $data['sms_opt'];
  $email_opt = $data['email_opt'];

  include __DIR__ .'/dbconfig.php';


  if(mysqli_connect_errno()){ 
      $result['status'] = false;
      $result['message'] = mysqli_connect_errno();

  }else { //db 연결성공
     $sql = "INSERT INTO Users (username, user_id, password, email, mobile_phone, home_phone
              , postal_code, address, address_detail, sms_opt, email_opt)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssii", $name, $id, $pw, $email, $phone, $tel, $postal_code, $address, $address_detail, $sms_opt, $email_opt);

    $queryResult = mysqli_stmt_execute($stmt);
    
      $result['status'] = true;

      if($queryResult){ 
        $result['message'] = "가입 성공";
      }else{ 
        $result['message'] = "가입 실패";
      }

      mysqli_stmt_close($stmt);
      mysqli_close($conn); 
      
  }

  return $result;

}