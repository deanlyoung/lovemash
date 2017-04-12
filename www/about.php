<?php
session_start();
include "common.php";
include_once "fbconnect.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>About - LoveMash</title>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="LoveMash - Play matchmaker. Connect your friends. Get all of the credit." />
		<meta name="keywords" content="matchmaker, lovemash, facebook" />
		<meta name="author" content="LoveMash, Inc." />
		<link rel="shortcut icon" href="favicon.ico"> 
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow&v1' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=PT+Serif+Caption:400,400italic' rel='stylesheet' type='text/css' />
		<link rel="image_src" href="images/lovemash-200.png" />
		<meta property="og:title" content="LoveMash"/>
		<meta property="og:type" content="website"/>
		<meta property="og:image" content="images/lovemash-200.png"/>
		<meta property="og:description" content="LoveMash - Play matchmaker. Connect your friends. Get all of the credit."/>
		<meta property="og:url" content="http://lovemash.deanlyoung.com"/>
		<meta property="og:site_name" content="LoveMash"/>
	</head>
	<body>
		<?php include_once("analyticstracking.php") ?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=461518593885961";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<div class="container">
			<div class="top" >
				<div class="main">
					<div class="logo">
						<a href="http://lovemash.deanlyoung.com"><img src="images/lovemash-300.png" /></a>
					</div> <!-- .logo -->
					<div class="loginout">
						<?php
							if (isset($_SESSION['user'])) echo '<a href="logout.php">Logout</a>';
							else echo '<a href="' . $loginUrl . '">Login</a>';
						?>
					</div> <!-- .loginout -->
				</div> <!-- .main -->
			</div> <!-- .top -->
			<div class="wrapper">
				<div id="container-area" class="container-area">
					<div class="container-area_p">
						<?PHP include "about-info.php" ?>
					</div> <!-- .container-area_p -->
					<div class="clr"></div>
					<div class="footer">
						<?PHP include "footer.php"; ?>
					</div>
				</div> <!-- #container-area -->
			</div> <!-- .wrapper -->
		</div> <!-- .container -->
		<div class="clr"></div>
	</body>
</html>