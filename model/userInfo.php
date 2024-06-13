<?php

function getUserInfo( $seq) {
    global $conn;
    
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {

        $stmt = mysqli_prepare($conn,"select * from Users where id = ?");
        mysqli_stmt_bind_param($stmt,"s",$seq);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        $result['data'] = mysqli_fetch_assoc($queryResult);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        if(isset($result['data'])){
            $result['status'] = true;
            $result['message'] = "조회 완료";
        } else {
            $result['status'] = false;
            $result['message'] = "조회 실패";
        }
    }

    return $result;
}

// 파일에 오류가 있으면 아예 전체 파일이 include가 안됨
function setUserInfo($seq, $data){
    global $conn;

    $result = array();
        
    // $name = $data['name'];
    $id = $seq;
    $user_id = $data['id'];
    $password = hash("sha256", $data['pw']);
    $email = $data['email'];
    // $phone = $data['phone'];
    $home_phone = $data['tel'];
    $postal_code = $data['postal_code'];
    $address = $data['address'];
    $address_detail = $data['address_detail'];
    $sms_opt = $data['sms_opt'];
    $email_opt = $data['email_opt'];

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $sql = "UPDATE Users
                SET user_id = ?, password = ?, email = ?, home_phone = ?, postal_code = ?, 
                    address = ?, address_detail = ?, sms_opt = ?, email_opt = ?
                WHERE id = ?";


        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssiii", $user_id, $password, $email, $home_phone, $postal_code, $address, $address_detail, $sms_opt, $email_opt, $id);

        $queryResult = mysqli_stmt_execute($stmt);

        $result['status'] = true;

        if($queryResult){ 
            $result['message'] = "수정 완료";
        }else{ 
            $result['message'] = "수정 실패";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn); 
    }
    return $result;
}


