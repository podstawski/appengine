<?php
    require_once __DIR__.'/google.php';
    
    $status=getStatus($service);
    
    die($status);