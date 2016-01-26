<?php
    require_once __DIR__.'/google.php';
    
    $status=getStatus($service);

    if ($status=='TERMINATED') startInstance($service);
    
    die($status);