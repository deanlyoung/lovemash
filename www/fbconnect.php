<?php
if (!isset($_SESSION['user'])) {
	//Application Configurations
	$app_id		= "XXX";
	$app_secret	= "XXX";
	$site_url	= "http://lovemash.deanlyoung.com";

	try {
		include_once "src/facebook.php";
	} catch(Exception $e) {
		error_log($e);
	}
	// Create our application instance
	$facebook = new Facebook(array(
		'appId'		=> $app_id,
		'secret'	=> $app_secret,
		));

	// Get User ID
	$user = $facebook->getUser();
	// We may or may not have this data based 
	// on whether the user is logged in.
	// If we have a $user id here, it means we know 
	// the user is logged into
	// Facebook, but we dont know if the access token is valid. An access
	// token is invalid if the user logged out of Facebook.
	//print_r($user);
	if ($user) {
		// Get logout URL
		$logoutUrl = $facebook->getLogoutUrl();
	} else {
		// Get login URL
		$params = array(
			'scope' => 'email, user_about_me, user_relationships, user_relationship_details, user_friends',
		);
		$loginUrl = $facebook->getLoginUrl($params);
	}

	if ($user) {
		try{
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me');
		//Connecting to the database. You would need to make the required changes in the common.php file
		//In the common.php file you would need to add your Hostname, username, password and database name!
		mysqlc();
		
		$fb_id = GetSQLValueString($user_profile['id'], "text");
		$username = GetSQLValueString($user_profile['username'], "text");
		$name = GetSQLValueString($user_profile['name'], "text");
		$first_name = GetSQLValueString($user_profile['first_name'], "text");
		$last_name = GetSQLValueString($user_profile['last_name'], "text");
		$email = GetSQLValueString($user_profile['email'], "text");
		$fb_email = "$user_profile[username]@facebook.com";
		$fb_emaili = GetSQLValueString($fb_email, "text");
		$gender = GetSQLValueString($user_profile['gender'], "text");
		$relationship_status = GetSQLValueString($user_profile['relationship_status'], "text");
		$imgurl = "https://graph.facebook.com/$user_profile[id]/picture?type=large";
		$imgurli = GetSQLValueString($imgurl, "text");
		
		$query = sprintf("SELECT * FROM newmember WHERE fb_id = %s",$fb_id);
		$res = mysql_query($query) or die('Query failed: ' . mysql_error() . "<br />\n$sql");
		
		if (mysql_num_rows($res) == 0) {
			$iquery = sprintf("INSERT INTO newmember VALUES('',%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,'yes',NOW())",$fb_id,$username,$name,$first_name,$last_name,$email,$fb_emaili,$gender,$relationship_status,$imgurli);
			$ires = mysql_query($iquery) or die('Query failed: ' . mysql_error() . "<br />\n$sql");
			$_SESSION['user'] = $user_profile['id'];
		} else {
			$row = mysql_fetch_array($res);
			$_SESSION['user'] = $row['fb_id'];
		}
		} catch(FacebookApiException $e) {
			error_log($e);
			$user = NULL;
		}
		
		$user_friends = $facebook->api('/me/taggable_friends', array('fields' => 'name,picture.width(180).height(180)', 'limit' => '5000'));
		
		$jquery = sprintf("SELECT * FROM newmember_friends WHERE user_fb_id = %s",$fb_id);
		$jres = mysql_query($jquery) or die('Query failed: ' . mysql_error() . "<br />\n$sql");
		
		if (mysql_num_rows($jres) == 0) {
			mysqlc();
			
			$kquery = "INSERT INTO newmember_friends(user_fb_id, friend_name, friend_photo) VALUES";
			$values = "";
		
			foreach ($user_friends['data'] as $item) {
				$values .= "('{$user_profile["id"]}', '" . mysql_real_escape_string($item["name"]) . "', '" . mysql_real_escape_string($item["picture"]["data"]["url"]) . "'),";
			}
		
			if ($values != "") {
				$values = substr($values, 0, strlen($values) -1);
				$values .= ";";
			} 
		
			$kquery .= $values;
		
			mysql_query($kquery);
		}
	}
	
}
?>