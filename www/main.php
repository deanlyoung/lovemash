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
				<img src="https://graph.facebook.com/<?php echo($row_left['friend_fb_id']);?>/picture?type=large" alt="friend 1's name" width="180px" height="180px" />
			</div>
			<div class="mash">
				<form name="lovemash" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
					<input type="hidden" name="userfbid" value="<?php echo $_SESSION['user'] ?>">
					<input type="hidden" name="matchthing1fbid" value="<?php echo $row_left['friend_fb_id'] ?>">
					<input type="hidden" name="matchthing1name" value="<?php echo $row_left['friend_name'] ?>">
					<input type="hidden" name="matchthing2fbid" value="<?php echo $row_right['friend_fb_id'] ?>">
					<input type="hidden" name="matchthing2name" value="<?php echo $row_right['friend_name'] ?>">
					<input type="submit" name="submit" id="submit" value="MashUp">
				</form>
				<?php
					if (isset($_POST['submit'])) {
						mysqlc();
						$mashup = "INSERT INTO newmatches (user_fb_id, match_thing1_fb_id, match_thing1_name, match_thing2_fb_id, match_thing2_name) VALUES ('$_POST[userfbid]','$_POST[matchthing1fbid]','$_POST[matchthing1name]','$_POST[matchthing2fbid]','$_POST[matchthing2name]')";
						$mashed = mysql_query($mashup);
					}
				?>
				<a id="skip" href="javascript:document.location.reload();" title="Skip" alt="Skip">skip</a>
			</div> <!-- .mash -->
			<div class="friend2-image">
				<img src="https://graph.facebook.com/<?php echo($row_right['friend_fb_id']);?>/picture?type=large" alt="friend 2's name" width="180px" height="180px" />
			</div>
		</span> <!-- .loggedin -->
</div> <!-- .picture -->
<div class="profile1">
	<h1 class="name1"><?php echo($row_left['friend_name']);?></h1>
	<div class="profile-info">
		<?php
			echo "<strong>FBID : </strong>" . $row_left['friend_fb_id'];
		?>
	</div> <!-- .profile-info -->
	<div class="clr"></div>
</div> <!-- .profile1 -->
<div class="profile2">
	<h1 class="name2"><?php echo($row_right['friend_name']);?></h1>
	<div class="profile-info-2">
		<?php
			echo "<strong>FBID : </strong>" . $row_right['friend_fb_id'];
		?>
	</div> <!-- .profile-info-2 -->
	<div class="clr"></div>
	<?php } ?>
</div> <!-- .profile2 -->