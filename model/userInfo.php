<?php

function getUserInfo( $loginId) {
    global $conn;
    
    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {

        $stmt = mysqli_prepare($conn,"select * from Users where user_id = ?");
        mysqli_stmt_bind_param($stmt,"s",$loginId);
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
// function setUserInfo(){
//     $result = array();
//     include __DIR__ .'/model/dbconfig.php';

//     if(mysqli_connect_errno()){
//         $result['status'] = false;
//         $result['message'] = mysqli_connect_errno();
//     } else {
        // $stmt = mysqli_prepare($conn,"");
        // mysqli_stmt_bind_param($stmt,"",);
        // mysqli_stmt_execute($stmt);
        // $queryResult = mysqli_stmt_get_result($stmt);

        // // 로직

        // mysqli_stmt_close($stmt);
        // mysqli_close($conn);
//     }
// }


