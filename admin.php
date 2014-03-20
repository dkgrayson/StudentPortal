<?php
    session_start();

    if (!isset($_SESSION["id"])) //Redirects to login page if trying to access this page before logging in
    {
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Project 3 CS 1520</title>
<link rel = "stylesheet" type = "text/css" href = "assig3.css"/>
<script type="text/javascript" language="javascript">
var stud; //Student ID
//DISPLAY TABLE WITH COURSES BY TERM//
//ALSO CHANGE TEXT TO RED IF TABLE IS SHOWN//
//OR BLUE IF TABLE IS NT SHOWN//
function showTableTerm()
{
    var tblTerm = document.getElementById("term");
    var option = document.getElementById("sterm");
    if (tblTerm.style.display == "none")
    {
         option.setAttribute("style", "color:red");
         tblTerm.style.display ="inline-block";
    }
    else
    {
        option.setAttribute("style", "color:#336699");
        tblTerm.style.display ="none";
    }
}

//DISPLAY TABLE WITH COURSES BY DEP AND NUM//
//ALSO CHANGE TEXT TO RED IF TABLE IS SHOWN//
//OR BLUE IF TABLE IS NT SHOWN//
function showAlpha()
{
    var tblAlpha = document.getElementById("alpha");
    var option = document.getElementById("salpha");
    if (tblAlpha.style.display == "none")
    {
        option.setAttribute("style", "color:red");
         tblAlpha.style.display ="inline-block";
    }
    else
    {
        option.setAttribute("style", "color:#336699");
        tblAlpha.style.display ="none";
    }
}

//DISPLAY TABLE WITH REQUIREMENTS//
//ALSO CHANGE TEXT TO RED IF TABLE IS SHOWN//
//OR BLUE IF TABLE IS NT SHOWN//
function showReq()
{
    var tblReq = document.getElementById("reqs");
    var option = document.getElementById("sreqs");
    if (tblReq.style.display == "none")
    {
        option.setAttribute("style", "color:red");
         tblReq.style.display ="inline-block";
    }
    else
    {
        option.setAttribute("style", "color:#336699");
        tblReq.style.display ="none";
    }
}

//FUNCTION TO LOOK UP STUDENT AND RETURN HTML OBJECT//
//IF THE PSID IS OUT OF RANGE, ALERT USER THAT HE/SHE//
//NEEDS TO ENTER A VALID PSID//
function findStudent()
{
	stud = document.getElementById("student").value;
	if(stud<999999 || stud>9999999)
	{
		alert("Please enter a valid student ID");
	}
	else
	{
		makeRequest("findstudent.php", stud);
	}
}

function makeRequest(url, stud) 
{
        var httpRequest;

        if (window.XMLHttpRequest) { // Mozilla, Safari, ...
            httpRequest = new XMLHttpRequest();
            if (httpRequest.overrideMimeType) {
                httpRequest.overrideMimeType('text/xml');
            }
        } 
        else if (window.ActiveXObject) { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
                                       }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { getStudent(httpRequest); };
        httpRequest.open('GET', url+"?stud="+stud, true);
        httpRequest.send();
}

function getStudent(httpRequest) 
{
    if (httpRequest.readyState == 4) 
    {
        if (httpRequest.status == 200) 
        {
            var divider = document.getElementById("div");
            divider.innerHTML = httpRequest.responseText;
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}

//FUNCTION TO LOG ADVISING SESSION AND RETURN HTML OBJECT//
function logSession()
{
	var httpRequest;
	//var stud = document.getElementById("student").value;
    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { log(httpRequest); };
        httpRequest.open('GET', "logsession.php?stud="+stud, true);
        httpRequest.send();
}
function log(httpRequest) 
{
    if (httpRequest.readyState == 4) 
    {
        if (httpRequest.status == 200) 
        {
        	var divider = document.getElementById("div2");
            divider.innerHTML = httpRequest.responseText;
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}

//FUNCTION TO SHOW ADVISING SESSIONS//
function showSession()
{
	var httpRequest;
	//var stud = document.getElementById("student").value;
    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { session(httpRequest); };
        httpRequest.open('GET', "showsession.php?stud="+stud, true);
        httpRequest.send();
}

function session(httpRequest)
{
	if (httpRequest.readyState == 4) 
    {
    	if (httpRequest.status == 200) 
        {
        	var divider = document.getElementById("div2");
            divider.innerHTML = httpRequest.responseText;
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}

//FUNCTION TO SHOW INPUT FIELDS FOR ADDING NOTES//
function addNotes()
{
	var txt = document.getElementById("notes");
	var sub = document.getElementById("submit");
	txt.style.display = "inline";
	sub.style.display = "inline";
}
//FUNCTION TO ADD NOTES//
function enterNotes()
{
	var notes = document.getElementById("notes").value;
	var httpRequest;
	//var stud = document.getElementById("student").value;

    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { sendNotes(httpRequest); };
        httpRequest.open('GET', "addnotes.php?stud="+stud+"&notes="+notes, true);
        httpRequest.send();
}

function sendNotes(httpRequest)
{
	if (httpRequest.readyState == 4) 
    {
    	if (httpRequest.status == 200) 
        {
        	alert("Advising Notes Successfully Added");
        	var txt = document.getElementById("notes");
			var sub = document.getElementById("submit");
			txt.style.display = "none";
			sub.style.display = "none";
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}

//FUNCTION TO SHOW LIST OF ADVISING NOTES//
function reviewNotes()
{
	var httpRequest;
	//var stud = document.getElementById("student").value;

    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { getNotes(httpRequest); };
        httpRequest.open('GET', "getnotes.php?stud="+stud, true);
        httpRequest.send();
}

function getNotes(httpRequest)
{
	if (httpRequest.readyState == 4) 
    {
    	if (httpRequest.status == 200) 
        {
        	var divider = document.getElementById("div3");
            divider.innerHTML = httpRequest.responseText;
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}

//FUNCTION TO LOOK UP A COURSE//
function findCourse()
{
	var dep = document.getElementById("dep").value;
	var cnum = document.getElementById("cnum").value;
	var httpRequest;

    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { getCourses(httpRequest); };
        httpRequest.open('GET', "findcourse.php?dep="+dep+"&cnum="+cnum, true);
        httpRequest.send();
}

function getCourses(httpRequest)
{
	if (httpRequest.readyState == 4) 
    {
    	if (httpRequest.status == 200) 
        {
        	var divider = document.getElementById("div0");
            divider.innerHTML = httpRequest.responseText;
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}

//FUNCTION TO SHOW FIELDS FOR ADDING USER//
function addUserShow()
{
    var divider = document.getElementById("div4");
    divider.style.display="inline";
}

//FUNCTION TO ACTUALLY ADD USER//
function addUser()
{
    var psid = parseInt(document.getElementById("psid").value);
    var uname = document.getElementById("uname").value;
    var pw = document.getElementById("pw").value;
    var email = document.getElementById("email").value;
    var lname = document.getElementById("lname").value;
    var fname = document.getElementById("fname").value;
    var alevel = parseInt(document.getElementById("alevel").value);
    //alert(psid+" "+uname+" "+pw+" "+email+" "+lname+" "+fname+" "+alevel);
    var httpRequest;

    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { getAddUser(httpRequest); };
        httpRequest.open('GET', "adduser.php?psid="+psid+"&uname="+uname+"&pw="+pw+"&email="+email
            +"&lname="+lname+"&fname="+fname+"&alevel="+alevel, true);
        httpRequest.send();
}

function getAddUser(httpRequest)
{
    if (httpRequest.readyState == 4) 
    {
        if (httpRequest.status == 200) 
        {
            var divider = document.getElementById("div4");
            divider.style.display="none";
            alert("User added successfully");
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}


//FUNCTION TO SHOW FORM FOR REMOVING USER//
function removeUserShow()
{
    var divider = document.getElementById("div5");
    divider.style.display="inline";
}

//FUNCTION TO ACTUALLY REMOVE USER//
function removeUser()
{
    var httpRequest;
    var psid = document.getElementById("idd").value;
    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { getRemoveUser(httpRequest); };
        httpRequest.open('GET', "removeuser.php?psid="+psid, true);
        httpRequest.send();
}

function getRemoveUser(httpRequest)
{
    if (httpRequest.readyState == 4) 
    {
        if (httpRequest.status == 200) 
        {
            var divider = document.getElementById("div5");
            divider.style.display="none";
            alert("User removed successfully");
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}

//FUNCTION TO SHOW FIELDS FOR ADDING COURSES//
function addCoursesShow()
{
    var divider = document.getElementById("div6");
    divider.style.display = "inline";
}

//FUNCTION TO ACTUALLY ADD COURSES//
function addCourses()
{
    var file = document.getElementById("coursefile").value;
    var httpRequest;
    if (window.XMLHttpRequest) 
    { // Mozilla, Safari, ...
        httpRequest = new XMLHttpRequest();
        if (httpRequest.overrideMimeType) 
        {
            httpRequest.overrideMimeType('text/xml');
        }
    } 
    else if (window.ActiveXObject) 
    { // IE
            try {
                httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
                } 
                catch (e) {
                           try {
                                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
                               } 
                             catch (e) {}
                          }
    }

        if (!httpRequest) 
        {
            alert('Giving up :( Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = function() { getAddCourses(httpRequest); };
        httpRequest.open('GET', "addcourses.php?file="+file, true);
        httpRequest.send();
}

function getAddCourses(httpRequest)
{
    if (httpRequest.readyState == 4) 
    {
        if (httpRequest.status == 200) 
        {
            var divider = document.getElementById("div6");
            divider.style.display="none";
            alert("Courses added successfully");
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}
</script>
</head>

<body>
    <div>
    <h1 style="margin-bottom:0;">Admin Dashboard</h1>
    <br/>
    <center><strong><a href="login.php?lo=1" style="color:black"><font FACE="algerian">Log Out</font></a></strong></center>
    <br/><br/><br/>
    <input type="submit" name = "submit6" value="Add a User" onClick='addUserShow()'/>
    <input type="submit" name = "submit7" value="Remove a User" onClick='removeUserShow()'/>
    <input type="submit" name = "submit8" value="Add Courses" onClick='addCoursesShow()'/><br/><br/>
    <br/><br/>
    <div id="div4" style="display:none">
    <opts>PSID</opts>
    <input type="text" id="psid" name="psid"/>
    <br/>
    <opts>Username</opts>
    <input type="text" id="uname" name="uname"/>
    <br/>
    <opts>Password</opts>
    <input type="password" id="pw" name="pw"/>
    <br/>
    <opts>E-mail</opts>
    <input type="text" id="email" name="email"/>
    <br/>
    <opts>Last Name</opts>
    <input type="text" id="lname" name="lname"/>
    <br/>
    <opts>First Name</opts>
    <input type="text" id="fname" name="fname"/>
    <br/>
    <opts>Access Level</opts>
    <select id="alevel">
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    </select>
    <br/>
    <input type="submit" value="Enter" name ="enter" onClick='addUser()'/>
    </div>

    <div id="div5" style="display:none">
    <br/>
    <opts>PSID</opts>
    <input type="text" id="idd" name="fname"/>
    <br/>
    <input type="submit" value="Remove" name ="remove" onClick='removeUser()'/>
    </div>

    <div id="div6" style="display:none">
    <br/><opts>File Name on Server</opts>
    <input type="text" id="coursefile"/>
    <br/>
    <input type="submit" value="Add From File" onClick='addCourses()'>
    </div>
    <br/><br/><br/>
	<opts>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Department</opts>
	<input type="text" id="dep" name="dep"/>
	<opts>(Capitalized)</opts>
	<br/>
	<opts>Course Number</opts>
	<input type="text" id="cnum" name="cnum"/><br/>
	<input type="submit" name="submitC" id="submitC" value="Look Up A Course" onClick='findCourse()'/>
	<br/><br/>

	<div id = "div0">
	</div>

	<opts>Student ID</opts>
	<input type="text" id = "student"/>
	<br/>
	<input type="submit" value="Search" onClick="findStudent()"/>


	<div id = "div">
	</div>
	<div id = "div2">
	</div>
	<div id = "div3">
	</div>
	<br/><br/>
	<textarea style="display:none" id = "notes" name = "notes" cols = "50" rows = "10">Enter Advising Notes Here....
	</textarea>
	<br/>
	<input style="display:none" type = "submit" id = "submit" name = "submit5" value = "Submit" onClick = 'enterNotes()'/>
	</form>
</body>
</html>