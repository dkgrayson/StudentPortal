<?php
//THIS FILE IS SUBMITTING NOTES BY THE ADVISOR
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

	date_default_timezone_set('America/New_York');
	$date = date('Y-m-d-H-i-s');
	$fname = $_GET["stud"] . ":" . $date;
	$fp = fopen("notes/". $fname . ".txt", "a+");
	fwrite($fp, $_GET["notes"]);
	fclose($fp);
	$db->query("insert into NOTES values ('$fname')"); //Put the label for these notes into the NOTES MYSQL TABLE

?>