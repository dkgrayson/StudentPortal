
<?php
//SCRIPT TO ADD USER TO DATABASE//
	session_start();
	if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
	{
		header("Location: login.php");
	}
	include "user.php";
	$passw = file("password.txt");
	$pw = rtrim($passw[0]);
	$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
	if ($db->connect_error)
	{
	    die ("Could not connect to db: " . $db->connect_error); 
	}

	$user = new user($_GET["psid"], hash('sha256', $_GET["pw"]), $_GET["uname"], $_GET["email"], $_GET["lname"], $_GET["fname"], 
		$_GET["alevel"]);


//MAKING USE OF USER CLASS HERE TO ADD TO DATABASE//
	$id = $user->getid();
	$uname = $user->getuname();
	$pw = $user->getpw();
	$email = $user->getemail();
	$lname = $user->getlname();
	$fname = $user->getfname();
	$alevel = $user->getalevel();

	$db->query("insert into USERS values ('$id', '$uname', '$pw', '$email', '$lname', '$fname', '$alevel')");
?>