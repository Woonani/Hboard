<?php
include
print_r($_POST());
if($_POST['mode'] == 'send_num') { 
    session_start();
    $_SESSION['authNum'] = '123456';
    die(json_encode(['result'=>'success']));
}