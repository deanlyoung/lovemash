<div class="main">
	<div class="logo">
		<a href="http://lovemash.deanlyoung.com"><img src="images/lovemash-300.png" /></a>
	</div> <!-- .logo -->
	<div class="loginout">
		<?php
			if (isset($_SESSION['user'])) echo '<a href="logout.php">Logout</h5></a>';
			else echo '<a href="' . $loginUrl . '">Login</a>';
		?>
	</div> <!-- .loginout -->
</div> <!-- .main -->