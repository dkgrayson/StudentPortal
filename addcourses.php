<?php
	//SCRIPT TO ADD COURSES TO DATABASE//
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


	//ADD COURSES TO COURSES TABLE//

		//READ IN LIST OF NEW COURSES TO ADD
		$file = rtrim("test/" . $_GET["file"]) . ".txt";
		$fp = fopen($file, "r");
		$users = array(); //Array to hold authorized users

		$i = 0; //Index for array

		while (!feof($fp)) //while we are not at the end of the file(filename)
		{ 
			$newcourses[$i] = preg_split("/:/", fgets($fp)); //Create an array inside of the array of users
			$i++;										  	//which contains each line of the file, split around the :
		}
		fclose($fp);

		//READ IN CURRENT COURSES LISTED IN MYSQL COURSES TABLE TO AVOID ADDING DUPLICATES
		$result = $db->query("select * from COURSES");
		$num_rows = $result->num_rows;
		$courses = array(); //Array to hold imported info from MYSQL

		//READ IN EACH ROW OF THE COURSES MYSQL TABLE AS AN ELEMENT IN AN ARRAY
		for($a=0;$a<$num_rows;$a++)
		{
			$courses[$a] = $result->fetch_array();
		}
		//USED TO MAKE COMPARISONS EASIER
		$courses2 = array();
		for($b = 0; $b<count($courses);$b++)
		{
			$courses2[$b][0] = $courses[$b][2];
			$courses2[$b][1] = $courses[$b][3];
			$courses2[$b][2] = $courses[$b][4];
			$courses2[$b][3] = $courses[$b][1];
			$courses2[$b][4] = $courses[$b][5];
			}
		sort($courses2);
		//print_r($courses2);
		$insert_index = $num_rows; //index for inserting new courses
		for($b=0;$b<count($newcourses);$b++)
		{	
			$found = false;
			for($c=0;$c<count($courses2);$c++)
			{	//IF DEPARTMENT, NUMBER, PSID, TERM AND GRADE MATCH, SET FOUND TO TRUE
				if(strcmp(rtrim($newcourses[$b][0]), rtrim($courses2[$c][0]))==0 && rtrim($newcourses[$b][1]) == rtrim($courses2[$c][1]) && $newcourses[$b][3] == $courses2[$c][3] && strcmp(rtrim($newcourses[$b][4]), rtrim($courses2[$c][4]))==0 && rtrim($newcourses[$b][2]) == rtrim($courses2[$c][2]))
				{
					$found = true;
					continue;
				}
			}
			if (!$found)
			{
				$nid = $newcourses[$b][3]; //PSID
				$ndep = $newcourses[$b][0]; //DEP
				$nnum = $newcourses[$b][1]; //NUM
				$nterm = $newcourses[$b][2]; //TERM
				$ngrade = $newcourses[$b][4]; //GRADE
				$db->query("insert into COURSES values('$insert_index', '$nid', '$ndep', '$nnum', '$nterm','$ngrade')");
				$insert_index++;
			}
		}
?>