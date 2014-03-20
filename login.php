<?php
//LOGIN PAGE
	session_start();
	if (isset($_GET["lo"]) && $_GET["lo"] == 1) //User has logged out, clear data
	{
		session_unset();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Project 3 CS 1520</title>
</head>
<body>

	<h1>Academic Portal</h1>
	<form action="redirect.php"
		  method="POST">

	<b>User Name</b>
	<input type="text" name="name"/>
	<br/>
	<b>Password&nbsp;&nbsp;</b>
	<input type="password" name="password"/>
	<br/>
	<input type="checkbox" name="forgot" value="fpass"/>ForgotPassword  
	<br/>
	<input type="checkbox" name="change" value="fpass"/>ChangePassword  
	<br/>
	<input type="submit" value="Enter"/>
<?php
		if (!isset($_GET["cm"]))
		{
		?>
	<?php	
		}
		elseif ($_GET["cm"] == 1) //Forgotten pw was emailed to user
		{
		?>
		<br/>
			<b>Please check your email for the password and try again</b>
	<?php	
		}
		elseif ($_GET["cm"] == 2) //Unknown user
		{
		?>
			<br/>
			<b>Unknown User</b>
	<?php	
		}
		elseif ($_GET["cm"] == 3) //Incorrect pw
		{
		?>
			<br/>
			<b>Incorrect Password</b>
	<?php	
		}
		elseif ($_GET["cm"] == 4) //Password changed
		{
		?>
			<br/>
			<b>Password Successfully Changed</b>
	<?php
		}
		?>
			</form>
</body>
</html>