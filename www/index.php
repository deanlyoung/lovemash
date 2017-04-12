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
						<div class="picture">
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
									$query_left = sprintf("SELECT * FROM newmember_friends WHERE user_fb_id = $fb_id ORDER BY Rand()");
									$res_left = mysql_query($query_left) or die('Query failed: ' . mysql_error() . "<br />\n$sql");
									$row_left = mysql_fetch_array($res_left);
								?>
								<?php
									mysqlc();
									$fb_id = GetSQLValueString($_SESSION['user'], "text");
									$query_right = sprintf("SELECT * FROM newmember_friends WHERE user_fb_id = $fb_id ORDER BY Rand()");
									$res_right = mysql_query($query_right) or die('Query failed: ' . mysql_error() . "<br />\n$sql");
									$row_right = mysql_fetch_array($res_right);
								?>
								<span class="loggedin">
									<div class="friend1-image">
										<img src="<?php echo($row_left['friend_photo']);?>" alt="friend 1's name" width="180px" height="180px" />
									</div>
									<div class="mash">
										<form name="lovemash" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
											<input type="hidden" name="userfbid" value="<?php echo $_SESSION['user'] ?>">
											<input type="hidden" name="matchthing1id" value="<?php echo $row_left['id'] ?>">
											<input type="hidden" name="matchthing1name" value="<?php echo $row_left['friend_name'] ?>">
											<input type="hidden" name="matchthing2id" value="<?php echo $row_right['id'] ?>">
											<input type="hidden" name="matchthing2name" value="<?php echo $row_right['friend_name'] ?>">
											<input type="hidden" name="matchorno" value="true">
											<input type="submit" name="submit" id="submit" value="Match">
										</form>
										<?php
											if (isset($_POST['submit'])) {
												mysqlc();
												$mashup = "INSERT INTO newmatches (user_fb_id, match_thing1_id, match_thing1_name, match_thing2_id, match_thing2_name, match_or_no) VALUES ('$_POST[userfbid]','$_POST[matchthing1id]','$_POST[matchthing1name]','$_POST[matchthing2id]','$_POST[matchthing2name]','$_POST[matchorno]')";
												$mashed = mysql_query($mashup);
											}
										?>
										<form name="lovemash" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
											<input type="hidden" name="userfbid" value="<?php echo $_SESSION['user'] ?>">
											<input type="hidden" name="matchthing1id" value="<?php echo $row_left['id'] ?>">
											<input type="hidden" name="matchthing1name" value="<?php echo $row_left['friend_name'] ?>">
											<input type="hidden" name="matchthing2id" value="<?php echo $row_right['id'] ?>">
											<input type="hidden" name="matchthing2name" value="<?php echo $row_right['friend_name'] ?>">
											<input type="hidden" name="matchorno" value="false">
											<select name="" class="">
												<option disabled selected value>Skip: choose one</option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
												<option value=""></option>
											</select>
											<input type="submit" name="skip" id="skip" value="skip">
										</form>
										<?php
											if (isset($_POST['skip'])) {
												mysqlc();
												$imashup = "INSERT INTO newmatches (user_fb_id, match_thing1_id, match_thing1_name, match_thing2_id, match_thing2_name, match_or_no, reason) VALUES ('$_POST[userfbid]','$_POST[matchthing1id]','$_POST[matchthing1name]','$_POST[matchthing2id]','$_POST[matchthing2name]','$_POST[matchorno]','$_POST[reason]')";
												$imashed = mysql_query($imashup);
											}
										?>
									</div> <!-- .mash -->
									<div class="friend2-image">
										<img src="<?php echo($row_right['friend_photo']);?>" alt="friend 2's name" width="180px" height="180px" />
									</div>
								</span> <!-- .loggedin -->
						</div> <!-- .picture -->
						<div class="profile1">
							<h1 class="name1"><?php echo($row_left['friend_name']);?></h1>
							<div class="profile-info">
								&nbsp; <!-- save for later -->
							</div> <!-- .profile-info -->
							<div class="clr"></div>
						</div> <!-- .profile1 -->
						<div class="profile2">
							<h1 class="name2"><?php echo($row_right['friend_name']);?></h1>
							<div class="profile-info-2">
								&nbsp; <!-- save for later -->
							</div> <!-- .profile-info-2 -->
							<div class="clr"></div>
							<?php } ?>
						</div> <!-- .profile2 -->
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