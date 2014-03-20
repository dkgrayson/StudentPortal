<?php
//THIS FILE IS THE FORM USED FOR ACCESSING PREVIOUS ADVISING NOTES
session_start();
if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
{
	header("Location: login.php");
}

//CONNECT TO MYSQL DATABASE
$passw = file("password.txt");
$pw = rtrim($passw[0]);
$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
if ($db->connect_error): 
    die ("Could not connect to db: " . $db->connect_error); 
endif;
?>

<!DOCTYPE html>
<html>
<head>
</head>
	<br/><br/>
	<h2 style="margin-bottom:0;">Review Advising Notes</h2>
	<br/><br/>
<?php
	$result = $db->query("select * from NOTES");
	$num_rows = $result->num_rows;
	$notes = array(); //Array to hold imported info from MYSQL
	for($a=0;$a<$num_rows;$a++)
	{
		$notes[$a] = $result->fetch_array();
		if(strncmp($_GET["stud"], $notes[$a][0], 7) == 0)//If userID matches note ID
		{
			$name = $notes[$a][0];
			$link = "notes/" . $notes[$a][0] . ".txt";
		
	?>
		<strong><a href=<?php echo $link; ?> style="color:black"><?php echo $name?></a></strong>
		<br/>
<?php
		}
	}
	?>
</body>
</html>