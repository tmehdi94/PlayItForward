	<li><a href="index.php">Home</a></li>
	<?php if (login_check($db) == true) { ?>
	<li class="active"><a href="account.php">Account</a></li>
	<li><a href="includes/logout.php">Logout</a></li>
	<?php } else { ?>
	<li><a href="login.php">Login/Register</a></li>
	<?php } ?>