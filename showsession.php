<?php
//SCRIPT TO SHOW ADVISING SESSIONS
	session_start();
	if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
	{
		header("Location: login.php");
	}
	$array_course = array();//ARRAY TO HOLD COURSE OBJECTS
	$passw = file("password.txt");
	$pw = rtrim($passw[0]);
	$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<link rel = "stylesheet" type = "text/css" href = "assig3.css"/>
		<h2 style="margin-bottom:0;">Advising Sessions</h2>
		<br/>
<?php
		$result = $db->query("select * from SESSIONS");
		$num_rows = $result->num_rows;
		$sess_array = array(); //Array to hold imported info from MYSQL

		//READ IN EACH ROW OF THE COURSES MYSQL TABLE AS AN ELEMENT IN AN ARRAY
		for($a=0;$a<$num_rows;$a++)
		{
			$sess_array[$a] = $result->fetch_array();
			if(strncmp($_GET["stud"], $sess_array[$a][0], 7) == 0)//If userID matches note ID
			{
				echo '<strong>'.$sess_array[$a][0] .'</strong>'. '<br/>';
			}
		}
?>
</body>