<?php

include '../../model/dbconfig.php';
include '../../model/review/list.php';


if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['plate'])&&isset($_GET['tag_no'])&&isset($_GET['col'])&&isset($_GET['word'])) {
        $result = getPageRange($_GET);
        
        if($result['status']){
            header('Content-Type: application/json');
            die( json_encode($result));
        } else {
            header('Content-Type: application/json');
            die( json_encode($result));
        } 
    } else if (isset($_GET['mode']) && $_GET['mode'] == 'list') {
        $result = getReviewList($_GET);
            
        if($result['status'] && isset($result['data'])){
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