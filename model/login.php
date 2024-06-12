<?php
// echo "로그인 model";

function login($data) {
    $result = array();

    include __DIR__ .'/dbconfig.php'; 
    $user_id = $data['id'];
    $password = hash('sha256', $data['pw']);

    if(mysqli_connect_errno()){
        $result['status'] = false;
        $result['message'] = mysqli_connect_errno();
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, username FROM Users WHERE user_id = ? AND password=?");
        mysqli_stmt_bind_param($stmt, "ss",  $user_id, $password);
        mysqli_stmt_execute($stmt);

        $queryResult = mysqli_stmt_get_result($stmt);
        $numRow = mysqli_num_rows($queryResult);

        $result['queryResult']=$queryResult;
        $result['numRow']=$numRow;

        if($numRow){
            $result['status'] = true;
            $result['login'] = "success";
            $result['id'] = $user_id;
            $result['message'] = '로그인 성공';
        }else{
            $result['status'] = true;
            $result['login'] = "fail";
            $result['message'] = '아이디/비밀번호 불일치';
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn); 
    }


        
    return $result;

}