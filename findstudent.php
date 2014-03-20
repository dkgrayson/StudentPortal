<?php
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

    $result = $db->query("select * from COURSES where id=".$_GET["stud"]);
    $num_rows = $result->num_rows;
    $courses = array();
    for($a=0;$a<$num_rows;$a++)
    {
        $courses[$a] = $result->fetch_array();
    }
    foreach ($courses as $key => $row) 
    {
            $dep[$key]  = $row[2];
            $num[$key] = $row[3];
            $term[$key]  = $row[4];
            $psid[$key] = $row[1];
            $grade[$key]  = $row[5];
    }
    if(count($courses)>1)
    array_multisort($term, SORT_ASC, $courses); //Sort $courses by term, with respect to keys in $courses

    $result2 = $db->query("select * from REQS");
    $num_rows = $result2->num_rows;
    $reqs = array();
    for($c=0;$c<$num_rows;$c++)
    {
        $reqs[$c] = $result2->fetch_array();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Project 3 CS 1520</title>
<link rel = "stylesheet" type = "text/css" href = "assig3.css"/>
</head>

<body>
        <br/>
        <opts><span
        id ="sterm"
        onclick='showTableTerm()'>
            Show Courses By Term
        </span></opts>
        <br/>
        <table style = "display:none" id="term" border=5 cellpadding=10 float: "left">
        <caption><strong>Courses by Term</strong></caption>
        <tr>
        <td><strong>PSID</strong></td>
        <td><strong>Department</strong></td>
        <td><strong>Number</strong></td>
        <td><strong>Term</strong></td>
        <td><strong>Grade</strong></td>
        </tr>
<?php
    for ($j = 0; $j < count($courses); $j++)
    {
?>
        

<?php
        if ($_GET["stud"] == $courses[$j][1])
        {
?>
        <tr>
<?php
            for ($k = 1; $k < 6; $k++)
            {
?>
                <td>
<?php
                echo '<strong>'.$courses[$j][$k] . " ".'</strong>';
?>
                </td>
<?php
            }
?>
        </tr>
<?php
        }
?>
        

<?php
    }
?>
    </table>
<?php
    //IN ORDER TO SORT CORRECTLY I HAD TO CREATE A NEW ARRAY TO SWAP THE ORDER OF THE OLD ARRAY//
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
?>
    <br/>
    <opts>
    <span
        id ="salpha"
        onclick='showAlpha()'>
            Show Courses by Department and Number
        </span></opts>
        <br/>
    <table style = "display:none" id = "alpha" border=5 cellpadding=10 float: "right">
    <caption><strong>Courses by Department and Number</strong></caption>
    <tr>
        <td><strong>Department</strong></td>
        <td><strong>Number</strong></td>
        <td><strong>Term</strong></td>
        <td><strong>PSID</strong></td>
        <td><strong>Grade</strong></td>
    </tr>
<?php
    for ($j = 0; $j < count($courses2); $j++)
    {
        if ($_GET["stud"] == $courses2[$j][3])
        {
?>      
        <tr>
<?php
            for ($k = 0; $k < 5; $k++)
            {
?>
                <td>
<?php
                echo '<strong>'.$courses2[$j][$k] . " ".'</strong>';
?>
                </td>
<?php
            }
?>
        </tr>
<?php
        }
    }
?>
    </table>
<?php
    $reqs2 = array();
    for($b = 0; $b<count($reqs);$b++)
    {
        $reqs2[$b][0] = $reqs[$b][1];
        $reqs2[$b][1] = $reqs[$b][2];
        $reqs2[$b][2] = $reqs[$b][3];
    }

$fulreq = array(); //array to hold whether requirements were fulfilled
$iter = 0;
for ($i = 0; $i < count($reqs); $i++) //Initialize array to all "N"
{
    
    if(($i +1) != count($reqs) && strcmp($reqs[$i][1], $reqs[$i +1][1]) == 0)
    {
        continue;
    }
    else
    {
        $fulreq[$iter][0] = "N"; //"N" = not satisfied
        $fulreq[$iter][1] = $reqs[$i][1]; //Requirement in question
        for ($j = 2; $j < 5; $j++)
        {
        $fulreq[$iter][$j] = " "; //Empty spaces for formatting later
        }
        $iter++;
    }
}

for ($p = 0; $p < count($courses2); $p++)
{
    //If grade is lower than a C, skip to the next course
    if (strcmp(rtrim($courses2[$p][4]), "C") != 0 && strcmp(rtrim($courses2[$p][4]), "C+") != 0 
    &&strcmp(rtrim($courses2[$p][4]), "B-") != 0 && strcmp(rtrim($courses2[$p][4]), "B") != 0 
    &&strcmp(rtrim($courses2[$p][4]), "B+") != 0 &&strcmp(rtrim($courses2[$p][4]), "A-") != 0 
    &&strcmp(rtrim($courses2[$p][4]), "A") != 0) 
    {
        continue;
    }   
    else
    {
        //check to see if ID matches
        if ($_GET["stud"] == $courses2[$p][3])
        {
            for ($o = 0; $o < count($reqs2); $o++)
            {
                for ($m = 0; $m < count($fulreq); $m++)
                {
                    if ($fulreq[$m][0]=="S")
                    {
                        continue;
                    }
                    //if requirement in fulreq matches requirement from course array and the requirement has not already been satisfied
                    elseif(strcmp(rtrim($fulreq[$m][1]), rtrim($reqs2[$o][0])) == 0 && strcmp($reqs2[$o][2], $courses2[$p][1])==0 && ($fulreq[$m][0] != "S"))
                    {
                        $fulreq[$m][0] = "S";
                        $fulreq[$m][2] = $courses2[$p][1]; //Course
                        $fulreq[$m][3] = $courses2[$p][2]; //Term
                        $fulreq[$m][4] = $courses2[$p][4]; //Grade
                        break;
                    }   
                }
            }
        }
        else
        {   //If ID doesn't match continue to next course
                continue;
        }
    }
}
?>
    <br/>
    <opts>
    <span
        id ="sreqs"
        onclick='showReq()'>
            Show Requirements List
    </span></opts>
    <br/>
    <table style = "display:none" id="reqs" border=5 cellpadding=10 float: "right">
    <caption><strong>Major Requirements</strong></caption>
    <tr>
        <td><strong>Satisfied/Not</strong></td>
        <td><strong>Requirement</strong></td>
        <td><strong>Course</strong></td>
        <td><strong>Term</strong></td>
        <td><strong>Grade</strong></td>
<?php
    for ($i = 0; $i < count($fulreq); $i++)
    {
?>
        <tr>
<?php
        for ($j = 0; $j < count($fulreq[$i]); $j++)
        {
?>
            <td>
<?php
            echo '<strong>'.$fulreq[$i][$j] . " ".'</strong>';
?>
            </td>
<?php
        }
?>
    </tr>
<?php
    }
?>
    </table>
    <br/><br/>
	<input type="submit" id = "submit1" value="Log Advising Session" onClick='logSession()'/>
	<input type="submit" id = "submit2" value="Show Advising Sessions" onClick='showSession()'/>
	<input type="submit" id = "submit3" value="Add Advising Notes" onClick='addNotes()'/>
	<input type="submit" id = "submit4" value="Review Advising Notes" onClick='reviewNotes()'/>
</body>
</html>