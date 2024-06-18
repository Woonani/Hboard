<?php
// session_start();

include '../../model/dbconfig.php';
include '../../model/admin/paging.php';



if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['plate'])) {

        $result = getPageRange($_GET['plate']);
        
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
} else {
    header('Content-Type: application/json', true, 400);
}