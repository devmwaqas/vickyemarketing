<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>Dear <?php echo ucwords($admin_details->first_name." ".$admin_details->last_name); ?>,</p>

	<p>You recently requested to reset password for your account.</p>

	<p>Your password has been changed your new password is <br> <p style="font-size: large;"> <b style="color: green"><?php echo trim($password); ?></b></p> Please use this password for login to <span style="color: blue;"><a href="<?php echo admin_url(); ?>"><?php echo admin_url(); ?></a></span></p>

	<p>Thanks</p>
</body>
</html>