<?php
session_start();
include "common.php";
include_once "fbconnect.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title>LoveMash</title>
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
						<a href="http://lovemash.us"><img src="images/lovemash-300.png" /></a>
					</div> <!-- .logo -->
					<div class="loginout">
						<?php
							if (isset($_SESSION['user'])) echo '<a href="logout.php">Logout</h5></a>';
							else echo '<a href="' . $loginUrl . '">Login</a>';
						?>
					</div> <!-- .loginout -->
				</div> <!-- .main -->
			</div> <!-- .top -->
			<div class="wrapper">
				<div id="container-area" class="container-area">
					<div class="container-area_p">
						<div class="picture">
							<?php if(isset($_SESSION['id'])) { ?>
								<span class="loggedin">
									<div class="friend1-image">
										<img src="https://graph.facebook.com/<?php echo $_SESSION['id']; ?>/picture?type=large" alt="friend 1's name" />
									</div>
									<div class="mash">
										<a id="mashup" href="http://lovemash.us/#" title="Mash" alt="Mash">Mash<span class="up">Up</span></a><br />
										<a id="skip" href="http://lovemash.us/#" title="Skip" alt="Skip">skip</a>
									</div>
									<div class="friend2-image">
										<img src="https://graph.facebook.com/<?php echo $_SESSION['id']; ?>/picture?type=large" alt="friend 2's name" />
									</div>
								</span> <!-- .loggedin -->
								<?php } ?>
							<?php if(!isset($_SESSION['user'])) { ?>
								<span class="loggedout">
									<div class="splash">
										<div id="lovemash_hype_container" style="position:relative;overflow:hidden;width:400px;height:200px;">
											<script type="text/javascript" charset="utf-8" src="lovemash.resources/lovemash_hype_generated_script.js?8176"></script>
										</div>
									</div>
									<div id="fb-connect-button">
										<span class="fb-connect-css">
											<a href='<?php echo $loginUrl ?>' class="fb-connect-buton" title="Connect to your Facebook Account"><span id="f">&nbsp;f&nbsp;</span><span id="line">|</span> Connect to your Facebook Account</a>
										</span> <!-- #fb-connect-button -->
									</div> <!-- #f-connect-button -->
								</span> <!-- .loggedout -->
							<?php } else { ?>
								<?php
									mysqlc();
									$fb_id = GetSQLValueString($_SESSION['user'], "text");
									$query = sprintf("SELECT * FROM newmember_friends WHERE user_fb_id = %s",$fb_id);
									$res = mysql_query($query) or die('Query failed: ' . mysql_error() . "<br />\n$sql");
									$row = mysql_fetch_array($res);
								?>
						</div> <!-- .picture -->
						<div class="profile1">
							<h1 class="name1"><?php echo($row['first_name']);?></h1>
							<div class="profile-info">
								<?php
									echo "<strong>GENDER : </strong>" . $row['gender'];
									if($row['relationship_status'] != "")
										echo "<br /><strong>STATUS : </strong>" . $row['relationship_status'];
									else
										echo "<br /><strong>STATUS : </strong>PRIVATE";
								?>
							</div> <!-- .profile-info -->
							<div class="clr"></div>
						</div> <!-- .profile1 -->
						<div class="profile2">
							<h1 class="name2"><?php echo($row['first_name']);?></h1>
							<div class="profile-info-2">
								<?php
									echo "<strong>GENDER : </strong>" . $row['gender'];
									if($row['relationship_status'] != "")
										echo "<br /><strong>STATUS : </strong>" . $row['relationship_status'];
									else
										echo "<br /><strong>STATUS : </strong>PRIVATE";
								?>
							</div> <!-- .profile-info-2 -->
							<div class="clr"></div>
							<?php } ?>
						</div> <!-- .profile2 -->
					</div> <!-- .container-area_p -->
					<div class="clr"></div>
					<div class="footer">
						<div class="fb-follow-outer">
							<div class="fb-follow" data-href="https://www.facebook.com/LoveMash.us" data-show-faces="false" data-font="arial" data-width="380"></div>
						</div>
						<div class="info">
							<ul class="info-list">
								<li>&nbsp;&nbsp;&nbsp;&copy;2013 LoveMash, Inc.</li>
								<li><a href="http://lovemash.us/#" title="privacy">privacy</a></li>
								<li><a href="http://lovemash.us/#" title="legal">legal</a></li>
								<li><a href="http://lovemash.us/#" title="about">about</a></li>
						</div>
					</div>
				</div> <!-- #container-area -->
			</div> <!-- .wrapper -->
		</div> <!-- .container -->
		<div class="clr"></div>
	</body>
</html>