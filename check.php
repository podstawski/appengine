<?php
    use google\appengine\api\users\User;
    use google\appengine\api\users\UserService;

	require_once __DIR__.'/google.php';
	
	require_once 'google/appengine/api/users/User.php';
	require_once 'google/appengine/api/users/UserService.php';
    
    $user=UserService::getCurrentUser();
	$mail = $user?$user->getNickname():'';
	$mail=explode('@',$mail);
    
    $status=getStatus($service);
    

    if ($status=='TERMINATED') startInstance($service,$mail[0]);
    
    die($status);