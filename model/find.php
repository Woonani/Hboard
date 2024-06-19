<?php
// 아이디 찾기
// 가입 유저 조회
function findUserId($data) {
    global $conn;
    
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {

        $stmt = mysqli_prepare($conn,"select * from Users where username = ? and (mobile_phone = ? or email = ?)");
        mysqli_stmt_bind_param($stmt,"sss", $data['username'], $data['mobil_phone'], $data['email']);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        $result['rowNum'] = mysqli_num_rows($queryResult);
        $result['data'] = mysqli_fetch_assoc($queryResult);

        // "find model : ".print_r($result);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        if($result['rowNum'] == 0) {
            $result['status'] = false;
            $result['message'] = "가입하지 않는 사용자입니다.";
        } else {
            if($result['data']>0){
                $result['status'] = true;
                $result['message'] = "조회 완료";
            } else {
                $result['status'] = false;
                $result['message'] = "조회 실패";
            }
        }
    }

    return $result;
}

// 비밀번호 찾기
function findUserPW($data) {
    global $conn;
    
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {

        $stmt = mysqli_prepare($conn,"select * from Users where user_id = ? and (mobile_phone = ? or email = ?)");
        mysqli_stmt_bind_param($stmt,"sss", $data['user_id'], $data['mobil_phone'], $data['email']);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);
        $result['rowNum'] = mysqli_num_rows($queryResult);
        $result['data'] = mysqli_fetch_assoc($queryResult);
        
        // "find model : ".print_r($result);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        if($result['rowNum'] == 0) {
            $result['status'] = false;
            $result['message'] = "가입하지 않는 사용자입니다.";
        } else {
            if($result['data']>0){
                $result['status'] = true;
                $result['message'] = "조회 완료";
            } else {
                $result['status'] = false;
                $result['message'] = "조회 실패";
            }
        }
    }

    return $result;
}