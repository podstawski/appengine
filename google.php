<?php
	use \google\appengine\api\mail\Message;
	
    require_once __DIR__.'/google-api-php-client/src/Google/autoload.php';
    
    function getClient() {
        $config = include __DIR__.'/ini.php';
        
        $client = new Google_Client();
        $client->setApplicationName("Webkameleon");
        $client->setClientId($config['oauth2_client_id']);
        $client->setClientSecret($config['oauth2_client_secret']);
        $client->setRedirectUri($config['oauth2_redirect_uri']);
        $client->setScopes($config['oauth2_scopes']);
        $client->setState('offline');
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');

        
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            die($client->getAccessToken());
        } elseif (!isset($config['token'])) {
            Header('Location: '.$client->createAuthUrl());
        } else {
            $client->setAccessToken($config['token']);
            if ($client->isAccessTokenExpired()) {
                $token=json_decode($config['token'],true);
                $client->refreshToken($token['refresh_token']);
            }
        }
        
        
        return $client;
    }
	
	function sendmail($subject,$config) {
		
		$mail_options = [
                "sender" => $config['mail_sender'],
                "to" => $config['mail_to'],
                "subject" => $subject.' '.$config['instance'][2].date(' y-m-d H:i'),
                "textBody" => print_r($_SERVER,true),
                "replyto" => $config['mail_from'],
                "header" => ['Resent-From'=>$config['mail_from']]
            ];

			
		try {
			$message = new Message($mail_options);
			$message->send();
		} catch (InvalidArgumentException $e) {
		}
			
			
	}
	
    
    function getStatus($service) {
        $config = include __DIR__.'/ini.php';
        $instance=$service->instances->get($config['instance'][0],$config['instance'][1],$config['instance'][2]);
        return $instance->status;
    }
    
    function startInstance($service,$who='') {
        $config = include __DIR__.'/ini.php';
        $service->instances->start($config['instance'][0],$config['instance'][1],$config['instance'][2]);
		sendmail('START '.$start,$config);
	}
    
    
    function stopInstance($service) {
        $config = include __DIR__.'/ini.php';
        $service->instances->stop($config['instance'][0],$config['instance'][1],$config['instance'][2]);
		sendmail('STOP',$config);
	}
    
    $client = getClient();
    $service = new Google_Service_Compute($client);
    
    
    
