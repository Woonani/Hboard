<?php

include '../../model/dbconfig.php';
include '../../model/review/reviewInfo.php';

// echo "hello";
// "../../controller/review/view.php?mode=view&seq=${data.rev_seq}">

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['mode'])) {

    if( $_GET['mode'] == 'view' && isset($_GET['seq'])) {

        $result = getReviewInfo($_GET['seq']);
        
        if($result['status']){
            header('Content-Type: application/json');
            die( json_encode($result));
        } else {
            header('Content-Type: application/json');
            die( json_encode($result));
        } 
    } else {
        header('Content-Type: application/json', true, 400);
    }
}