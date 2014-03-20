<?php
//SCRIPT TO REMOVE A USER
	session_start();
	if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
	{
		header("Location: login.php");
	}
	$passw = file("password.txt");
	$pw = rtrim($passw[0]);
	$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
	if ($db->connect_error)
	{
	    die ("Could not connect to db: " . $db->connect_error); 
	}

	//REMOVE USER FROM USERS TABLE//
	$removeid = $_GET["psid"];
	$db->query("delete from USERS where USERS.id = '$removeid'");
?>
