<?php
    $config = ['oauth2_client_id'=>"",
               'oauth2_client_secret'=>"",
               'oauth2_redirect_uri'=>'http://'.$_SERVER['HTTP_HOST'].'/',
               'oauth2_scopes'=>'https://www.googleapis.com/auth/compute',
               'token'=>'',
               'instance'=>['','',''],
               'iframe_src'=>'',
               'status'=>'http://status02.webkameleon.com',
               'log_dir'=>'/var/log/apache2',
               'log_timeout'=>360,
               'server_min_uptime'=>2000,
               'kameleon'=>[['dsn'=>'pgsql:host=localhost;dbname=cmspremium','user'=>'cmsdecora','pass'=>'spierdalaj']],
               'kameleon_ftp_timeout'=>600
    ];
    
    if (file_exists(__DIR__.'/local.php')) {
        $local=include __DIR__.'/local.php';
        foreach ($local AS $k=>$v) $config[$k]=$v;
    }
    
    return $config;