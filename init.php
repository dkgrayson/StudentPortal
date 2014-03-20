<?php
//INITALIZATION PAGE
$passw = file("password.txt");
$pw = rtrim($passw[0]);
$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
if ($db->connect_error): 
    die ("Could not connect to db: " . $db->connect_error); 
endif;
//CREATE TABLE TO HOLD SESSIONS////////////////////////////////////////////////////////////////////////////////
//Drop table sessions
$result = $db->query("drop table SESSIONS");
$result = $db->query("create table SESSIONS (session char(50) primary key not null)") or die ("Invalid: " . $db->error);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CREATE TABLE TO HOLD NOTES////////////////////////////////////////////////////////////////////////////////
//Drop table notes
$result = $db->query("drop table NOTES");
$result = $db->query("create table NOTES (notes char(50) primary key not null)") or die ("Invalid: " . $db->error);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CREATE TABLE TO HOLD USERS////////////////////////////////////////////////////////////////////////////////
//Drop table users
$result = $db->query("drop table USERS");
//Create new table with users, primary key is his/her userID
$result = $db->query("create table USERS (id int primary key not null, uname char(30) not null, pw char(200),
	email char(30), lname char(30), fname char(30), alevel int)") or die ("Invalid: " . $db->error);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CREATE ARRAY OF USER INFORMATION FROM USERS.TXT////////////////////////////////////////////////////////////
$fp = fopen("users.txt", "r");
$users = array(); //Array to hold authorized users

$i = 0; //Index for array

while (!feof($fp)) //while we are not at the end of the file(filename)
{ 
	$users[$i] = preg_split("/:/", fgets($fp)); //Create an array inside of the array of users
	$i++;										  	//which contains each line of the file, split around the :
}
fclose($fp);

foreach ($users as $key => $row) 
{
	$uname[$key]  = rtrim($row[0]);
	$password[$key] = hash('sha256', rtrim($row[1]));
	$pid[$key]  = rtrim($row[2]);
    $email[$key] = rtrim($row[3]);
    $lname[$key]  = rtrim($row[4]);
    $fname[$key]  = rtrim($row[5]);
    $alevel[$key]  = rtrim($row[6]);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//USER ARRAY OF USERS TO ADD INFORMATION TO MYSQL USER TABLE///////////////////////////////////////////////////
for ($j = 0; $j < count($users); $j++) //Step through list of users
	{
		$query = "insert into USERS values ('$pid[$j]', '$uname[$j]', '$password[$j]', '$email[$j]', '$lname[$j]','$fname[$j]', '$alevel[$j]')";
		$db->query($query) or die ("Invalid insert " . $db->error);
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


//CREATE TABLE TO HOLD COURSES////////////////////////////////////////////////////////////////////////////////
//Drop table users
$result = $db->query("drop table COURSES");
//Create new table with courses, primary key userID
$result = $db->query("create table COURSES (intid int primary key not null, id int, dep char(30) not null, num int,
	term int, grade char(30))") or die ("Invalid: " . $db->error);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CREATE ARRAY OF COURSE INFORMATION FROM COURSES.TXT////////////////////////////////////////////////////////////
$fpp = fopen("courses.txt", "r");
$courses = array(); //Array to hold course information

$m = 0; //Index for array

while (!feof($fpp)) //while we are not at the end of the file
{ 
	$courses[$m] = preg_split("/:/", fgets($fpp)); //Create an array inside of the array of courses
	$m++;										  	//which contains each line of the file, split around the :
}

foreach ($courses as $key => $row) 
{
	$dep[$key]  = rtrim($row[0]);
	$num[$key] = rtrim($row[1]);
	$term[$key]  = rtrim($row[2]);
    $id[$key] = rtrim($row[3]);
    $grade[$key]  = rtrim($row[4]);
}

//USER ARRAY OF COURSES TO ADD INFORMATION TO MYSQL COURSES TABLE///////////////////////////////////////////////
for ($n = 0; $n < count($courses); $n++) //Step through list of users
	{
		$query = "insert into COURSES values ('$n','$id[$n]', '$dep[$n]', '$num[$n]', '$term[$n]', '$grade[$n]')";
		//echo $query . '<br/>';
		$db->query($query) or die ("Invalid insert " . $db->error);
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
fclose($fpp);

//CREATE TABLE TO HOLD REQS////////////////////////////////////////////////////////////////////////////////
//Drop table users
$result = $db->query("drop table REQS");
//Create new table with courses, primary key userID
$result = $db->query("create table REQS (id int primary key not null, req char(30), dep char(30), num int)") or die ("Invalid: " . $db->error);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//CREATE ARRAY OF REQ INFORMATION FROM REQ.TXT////////////////////////////////////////////////////////////
$fppp = fopen("req.txt", "r");
$req = array(); //Array to hold req information

$k = 0; //Index for array

while (!feof($fppp)) //while we are not at the end of the file
{ 
	$req[$k] = preg_split("/[:,|]/", fgets($fppp)); //Create an array inside of the array of reqs
	$k++;										  	//which contains each line of the file, split around the :
}

fclose($fppp);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

$a = 0;
//USER ARRAY OF REQS TO ADD INFORMATION TO MYSQL REQ TABLE///////////////////////////////////////////////
for ($b = 0; $b < count($req); $b++) //Step through list of users
	{
		for($c = 1; $c < count($req[$b]); $c += 2 )
		{
			$requirement = rtrim($req[$b][0]);
			$department = rtrim($req[$b][$c]);
			$number = rtrim($req[$b][$c+1]);
			$query = "insert into REQS values ('$a','$requirement', '$department', '$number')";
			$db->query($query) or die ("Invalid insert " . $db->error);
			$a++;
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////

//GO TO LOGIN PAGE

header("Location: login.php")
?>