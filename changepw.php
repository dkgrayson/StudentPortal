<?php
//THIS FILE REDIRECTS LOGIN SELECTIONS
session_start();
if (!isset($_SESSION["name"])) //Redirects to login page if trying to access this page before logging in
{
	header("Location: login.php");
}

$passw = file("password.txt");
$pw = rtrim($passw[0]);
$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
if ($db->connect_error): 
    die ("Could not connect to db: " . $db->connect_error); 
endif;

$uname = $_SESSION["name"];
?>


<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
</head>
<body>
	<h1>Change Password</h1>
	<form action="changepw.php"
		  method="POST">

	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Old Password</b>
	<input type="password" name="password"/>
	<br/>
	<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Password</b>
	<input type="password" name="newpw"/>
	<br/>
	<b>Confirm New Password</b>
	<input type="password" name="newpw2"/>
	<br/>
	<input type="submit" value="Enter"/>
</form>
	<?php
		if (!isset($_POST["password"]) || !isset($_POST["newpw"]) || !isset($_POST["newpw2"]))
		{
		}
		else
		{
			$result = $db->query("select * from USERS");
			$num_rows = $result->num_rows;
			for ($i = 0; $i < $num_rows; $i++)
			{
				$user = $result->fetch_array();
				if(strcmp(hash('sha256', $_POST["password"]), $user[2])==0) //Password matches
				{
					if(strcmp($_POST["newpw"], $_POST["newpw2"]) == 0) //New password verified
					{
						$newpw = hash('sha256', $_POST["newpw2"]);
						$db->query("update USERS set USERS.pw = '$newpw' where USERS.uname = '$uname'"); //replace pw in USERS 																						table
						header("Location: login.php?cm=4"); //Return to login
						exit;
					}
					else
					{
						echo "Please make sure your new password matches in both boxes.";
					}
				}
			}
			echo "Please enter the correct password";
		}
	?>
	<br/>
	<br/>
<a href="login.php?lo=1">BACK</a>

</body>
</html>