<?php
    use google\appengine\api\users\User;
    use google\appengine\api\users\UserService;

	require_once __DIR__.'/google.php';
	$config = include __DIR__.'/ini.php';
	
	
	if (!$config['iframe_src']) {
        require_once 'google/appengine/api/users/User.php';
        require_once 'google/appengine/api/users/UserService.php';
		
		$user=UserService::getCurrentUser();
		$mail = $user?$user->getNickname():'';
		$mail=explode('@',$mail);
		if ($mail[0]) $config['iframe_src']='http://'.$mail[0].'.webkameleon.com';
	}
	
	if (!$config['iframe_src']) die();
	
	$host=$config['iframe_src'];
	$iframe_src=$host.$_SERVER['REQUEST_URI'];
	
	
?><html>
<head>
	<style>
		body {
			border: 0;
			padding: 0;
			margin: 0;
			overflow: hidden;
		}
		iframe {
			border: 0;
			padding: 0;
			margin: 0;
			width: 100%;
			height: 100%;
			display: block;
		}
		
		img {
			max-width: 100%;
		}
		
		.loading {
			position: absolute;
			z-index: 10;
			text-align: center;
			width: 100%;
		}
		
		.loading img {
			max-width: 25%;
			margin-top: 2%
		}
	</style>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>
	
	<div class="loading">
		<img src="/media/loading_icon.gif" />
	</div>
	<p align="center">
		<img src="/media/tablica.jpg"/>
	</p>
	
</body>

<script>
	document.domain = 'webkameleon.com';
	
	function ifr() {
		$('body').html('<iframe src="<?php echo $iframe_src;?>"></iframe>');
		$('iframe').load(function(){
			var lh=this.contentWindow.location.href;
			lh=lh.replace('<?php echo $host;?>','');
			history.pushState('', this.contentWindow.document.title, 'http://'+location.hostname+lh);
			document.title = this.contentWindow.document.title;
		});
	}
	
	ifr();
</script>

</html>
