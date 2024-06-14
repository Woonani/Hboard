<?php

// 강의 정보 가져오는 함수
function getLectureInfo () {
    global $conn;

    $result = array();

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $stmt = mysqli_prepare($conn,"select * from Lectures");
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

?>