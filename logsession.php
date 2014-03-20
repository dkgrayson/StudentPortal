<?php
//SCRIPT TO LOG ADVISING SESSION
session_start();

if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
{
	header("Location: login.php");
}

//CONNECT TO MYSQL
$passw = file("password.txt");
$pw = rtrim($passw[0]);
$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
if ($db->connect_error): 
    die ("Could not connect to db: " . $db->connect_error); 
endif;
	date_default_timezone_set('America/New_York'); //Set timezone
	$date = date('Y-m-d-H-i-s'); //Get current date in correct format
	$session = $_GET["stud"] . ":" . $date;
	$db->query("insert into SESSIONS values ('$session')"); //Put this session into the SESSIONS MYSQL TABLE
?>
<?php echo '<strong>'.'<br/>'.'<br/>'."Advising Session Logged Under: ". $session .'</strong>'; ?>