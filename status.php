<?php
    require_once __DIR__.'/google.php';
    
    $status=getStatus($service);
    if ($status!='RUNNING') return;
    
    
    $config = include __DIR__.'/ini.php';
    
    $canStop=file_get_contents($config['status']);
    
    

    //if ($status=='TERMINATED') startInstance($service);
    
    die($status);