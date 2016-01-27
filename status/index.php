<?php
    
    Header('Access-Control-Allow-Origin: *');

    $config = include __DIR__.'/../ini.php';


    $debug='';
    
    $uptime=file_get_contents('/proc/uptime');
    $uptime=explode(' ',$uptime);
    $uptime=$uptime[0];


    if (isset($_GET['debug'])) $debug='<br/>Uptime='.$uptime; 
    if ($uptime < $config['server_min_uptime']) die('0'.$debug);
    

    //$chromoting='';
    //foreach (scandir('/tmp') AS $tmp) if (substr($tmp,0,10)=='chromoting') $chromoting=$tmp;
    //if ($chromoting) die('0');

    
    $dir=$config['log_dir'];
    $min=$config['log_timeout'];
    foreach(scandir($dir) AS $log) {
        if ($log[0]=='.' || $log=='error.log' || $log=='access.log') continue;
        if (substr($log,-3)=='.gz') continue;
        if (strstr($log,'status')) continue;
        $min=min($min,time()-filemtime("$dir/$log"));
        
    }
    if (isset($_GET['debug'])) $debug='<br/>Logs='.$min; 
    if ($min<$config['log_timeout']) die('0'.$debug);
    
    
    foreach ($config['kameleon'] AS $db) {
        try {
            $conn=new PDO($db['dsn'],$db['user'],$db['pass']);
            $sql="SELECT nczas FROM ftplog ORDER BY id DESC LIMIT 1;";
            $q=$conn->query($sql);
            foreach ($q AS $row);
            $lastftp=$row[0];
            
            if (isset($_GET['debug'])) $debug='<br/>Kameleon='.(time()-$lastftp); 
            if (time()-$lastftp < $config['kameleon_ftp_timeout'] ) die('0'.$debug);
            
        } catch (Exception $e) {
            print_r($e);
            die('0'.$debug);
        }
    }
    
    die('1');
