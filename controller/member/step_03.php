<?php
session_start();
include '../../model/dbconfig.php'; 
include '../../model/member/signin.php'; 

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    die( json_encode(['status' => 'success', 'data' => $_SESSION['user_phone_num']]));

}else if($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    
    // 아이디 중복 체크
    if($_POST['mode'] == 'id_dup_chk') { 
        $result = checkId($_POST['data']);
        
        if($result['status']){
            
            if($result['dub_chk'] > 0){
                header('Content-Type: application/json');
                die( json_encode(['status' => 'success', 'numRow'=>$result['numRow'], 'message' => $_POST['data'].'는 '.$result['message']]));
    
            } else {
                header('Content-Type: application/json');
                die( json_encode(['status' => 'fail', 'numRow'=>$result['numRow'],'message' => $result['message']]));
            }
        } else {
                header('Content-Type: application/json');
                die( json_encode(['status' => 'fail', 'message' => $result['message']]));
        
        }
        
    }
}
