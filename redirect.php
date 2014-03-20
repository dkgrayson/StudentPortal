<?php
//THIS FILE REDIRECTS LOGIN SELECTIONS
session_start();
//if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
//{
//	header("Location: login.php");
//}

$passw = file("password.txt");
$pw = rtrim($passw[0]);
$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
if ($db->connect_error): 
    die ("Could not connect to db: " . $db->connect_error); 
endif;

if (isset($_POST["name"]))
{
	$_SESSION["name"] = $_POST["name"]; //Remember the userID
	$uname = $_POST["name"];
}
if (isset($_POST["password"]))
{
	echo $_POST["password"] . '<br/>';
	$_SESSION["password"] = hash('sha256', rtrim($_POST["password"]));

}
// Get the number of rows in the result, as well as the first row
//  and the number of fields in the rows

$result = $db->query("select * from USERS");
$num_rows = $result->num_rows;
for ($i = 0; $i < $num_rows; $i++)
{
	$user = $result->fetch_array();
	if (strcmp($uname, $user[1])==0) //FOUND USER
	{
		if (isset($_POST["forgot"]))//Found user but forgot password
		{
			//GENERATE A RANDOM PASSWORD BETWEEN 5-10 CHARACTERS
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$newpw = '';
			for ($a = 0; $a < 5; $a++)
			{
				$newpw .= $characters[rand(0, strlen($characters)-1)];
			}
				mail($user[3], "Password Recovery", rtrim($newpw)); //Mail pw to email on file
				$newpw = hash('sha256', rtrim($newpw));

				$db->query("update USERS set USERS.pw = '$newpw' where USERS.uname = '$uname'"); //replace pw in USERS 
				header("Location: login.php?cm=1"); //Return to login
			exit;
			
		}
		if (isset($_POST["change"]))//User wants to change password
		{
			header("Location: changepw.php");
			exit;
		}
		if(strcmp($_SESSION["password"], $user[2])==0) //FOUND PASSWORD
		{
			//echo "FOUND PASSWORD";

			if($user[6]==0)//ACCESS LEVEL 0, STUDENT
			{
				$_SESSION["id"] = $user[0];
				header("Location: advisee.php");
				exit;
			}
			if($user[6]==1)//ACCESS LEVEL 1, ADVISOR
			{
				$_SESSION["id"] = $user[0];
				$_SESSION["alevel"] = 1;
				header("Location: advisor.php");
				exit;
			}
			if($user[6]==2)//ACCESS LEVEL 2, ADMINISTRATOR
			{
				$_SESSION["id"] = $user[0];
				$_SESSION["alevel"] = 2;
				header("Location: admin.php");
				exit;
			}
		}
		else //found user but incorrect password
		{
			header("Location: login.php?cm=3");
			exit;
		}
	}	

}
header("Location: login.php?cm=2"); //userID was not found