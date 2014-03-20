<?php
	session_start();
	if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
	{
		header("Location: login.php");
	}
	include 'course.php'; //INCLUDE COURSE CLASS
	$array_course = array();//ARRAY TO HOLD COURSE OBJECTS
	$passw = file("password.txt");
	$pw = rtrim($passw[0]);
	$db = new mysqli('localhost', 'GraysonD', $pw, 'GraysonD');
	if ($db->connect_error)
	{
	    die ("Could not connect to db: " . $db->connect_error); 
	}

	$result = $db->query("select * from COURSES");
	$num_rows = $result->num_rows;
	$courses = array(); //Array to hold imported info from MYSQL
	$courses2 = array(); //Array to hold a better formatted version of $courses

	//READ IN EACH ROW OF THE COURSES MYSQL TABLE AS AN ELEMENT IN AN ARRAY
	for($a=0;$a<$num_rows;$a++)
	{
		$courses[$a] = $result->fetch_array();
	}

	//INITIALIZE A COURSES2 ARRAY FOR BETTER FORMATTING FOR SORTING LATER ON
	//ALSO USED THIS TO MAKE COURSE OBJECTS STORED IN $ARRAY_COURSE
	for($b = 0; $b<count($courses);$b++)
	{
		$courses2[$b][0] = $courses[$b][2]; //Dept
		$courses2[$b][1] = $courses[$b][3];	//Num
		$courses2[$b][2] = $courses[$b][4]; //Term
		$courses2[$b][3] = $courses[$b][1]; //PSID
		$courses2[$b][4] = $courses[$b][5]; //GRADE
		$array_course[$b] = new course($courses2[$b][0], $courses2[$b][1], $courses2[$b][2], $courses2[$b][4], $courses2[$b][3]);
	}

?>

		<br/><br/>
		<table style = "display: inline-block" border=5 cellpadding=10 float: "left">
		<caption><strong>Course Listing</strong></caption>
		<tr>
		<td><strong>Department</strong></td>
		<td><strong>Number</strong></td>
		<td><strong>PSID</strong></td>
		<td><strong>Grade</strong></td>
<?php
		$average_gpa = 0; //Value to hold average GPA of class
		$num_classes = 0;
		for($d = 0; $d < count($array_course); $d++)
		{
			if( $_GET["cnum"] == $array_course[$d]->getnum() && $_GET["dep"] == $array_course[$d]->getdept())
			{
?>
				<tr>
<?php
				echo '<td>'.$array_course[$d]->getdept().'</td>'.'<td>'.$array_course[$d]->getnum().'</td>'.
				'<td>'.$array_course[$d]->getpsid().'</td>'.'<td>'.$array_course[$d]->getgrade().'</td>';
				$average_gpa = $average_gpa + $array_course[$d]->getgpa(); //Adds value of grade to running total of grade values
				$num_classes++;
?>
				</tr>
<?php
			}
		}
?>
	</table>
	<br/>
	<br/>
	<div id="header">
	<h2 style="margin-bottom:0;">Average GPA for the Class:</h2>
	<br/>
<?php
	$average_gpa = $average_gpa/$num_classes; //Calculates average GPA
	echo '<strong>'.'<font size="5">'.$average_gpa.'</font>'.'</strong>'.'<br/>'.'<br>';
?>