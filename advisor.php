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
var stud;//HOLDS STUDENT ID
//FUNCTION TO SHOW COURSES BY TERM
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
//FUNCTION TO SHOW COURSES BY DEP AND NUM
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
//FUNCTION TO SHOW REQUIREMENTS TABLE
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
//FUNCTION TO FIND STUDENT//
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
//FUNCTION TO LOG ADVISING SESSION
function logSession()
{
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
//FUNCTION TO SHOW ADVISING SESSSIONS
function showSession()
{
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
//FUNCTION TO ADD NOTES
function addNotes()
{
	var txt = document.getElementById("notes");
	var sub = document.getElementById("submit");
	txt.style.visibility = "visible";
	sub.style.visibility = "visible";
}

function enterNotes()
{
	var notes = document.getElementById("notes").value;
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
			txt.style.visibility = "hidden";
			sub.style.visibility = "hidden";
        } 
        else 
        {
            alert('There was a problem with the request.');
        }
    }
}
//FUNCTION TO REVIEW ADVISING NOTES
function reviewNotes()
{
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
//FUNCTION TO LOOKUP A COURSE
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
</script>
</head>

<body>
    <div>
    <h1 style="margin-bottom:0;">Advisor Dashboard</h1>
    <br/>
    <center><strong><a href="login.php?lo=1" style="color:black"><font FACE="algerian">Log Out</font></a></strong></center>
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
	<textarea style="visibility:hidden" id = "notes" name = "notes" cols = "50" rows = "10">Enter Advising Notes Here....
	</textarea>
	<br/>
	<input style="visibility:hidden" type = "submit" id = "submit" name = "submit5" value = "Submit" onClick = 'enterNotes()'/>
	</form>
</body>
</html>