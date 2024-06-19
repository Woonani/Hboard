<?php

// session_start();

include __DIR__ .'/model/dbconfig.php';
include __DIR__ .'/model/admin/paging.php';

$data['plate'] = 2;

$result = getPageRange($data);

print_r($result);
