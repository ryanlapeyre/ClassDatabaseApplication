<!DOCTYPE html>


<?php
if(
		!isset($_POST['deleteClassName']) && 
		!isset($_POST['deleteDepartmentName']) &&
		!isset($_POST['deleteCourseID']) &&
		!isset($_POST['deleteStartTime']) && 
		!isset($_POST['deleteEndTime']) &&
		!isset($_POST['deleteDays'])



  )

{
	$_POST['deleteClassName'] = "";
	$_POST['deleteDepartmentName'] = "";
	$_POST['deleteCourseID'] = "";
	$_POST['deleteStartTime'] = "";
	$_POST['deleteEndTime'] = "";
	$_POST['deleteDays'] = "";


}

?>
<html lang = "en"> 

<head>

<title>Delete Page Lab10</title>

<meta charset = "UTF-8">


<!--  I USE BOOTSTRAP BECAUSE IT MAKES FORMATTING/LIFE EASIER -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"><!-- Optional theme -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->

<style>

input[type=text] {
width: 50%;
padding: 12px 20px;
margin: 8px 0;
		box-sizing: border-box;
		font-size:20px;
}
div
{
	text-align:center;

}


a , p
{

	font-size:20px;

}


input[type=button], input[type=submit], input[type=reset] {
	background-color: #254170;
border: none;
color: white;
padding: 16px 32px;
		 text-decoration: none;
margin: 4px 2px;
cursor: pointer;
}



</style>


</head>


<div>
<body>



<a href="http://cs3380.rnet.missouri.edu/~rml3md/lab9/lab9.php">Home</a></br></br>


<?php

$passedCourseID = $_POST['deleteCourseID'];
$passedClassName = $_POST['deleteClassName'];
$passedDepartmentName = $_POST['deleteDepartmentName'];
$passedStartTime = $_POST['deleteStartTime'];
$passedEndTime = $_POST['deleteEndTime'];
$passedDays = $_POST['deleteDays'];





?>




<form method = 'POST'>


<p>Course ID </p>
<input type = 'text' name = 'readOnlyCourseID' value = '<?php echo $passedCourseID ?>' readonly>
<br>

<p>Department Name </p>
<input type = 'text' name = 'displayDepartment' value = '<?php echo $passedDepartmentName ?>'readonly  >
<br>

<p>Class Name</p>
<input type = 'text' name = 'displayClassName' value =  '<?php echo $passedClassName ?>' readonly> 
<br>

<p>Start Time </p>
<input type = 'text' name = 'displayStartTime' value = '<?php echo $passedStartTime ?>' readonly>
<br>

<p>End Time </p>
<input type = 'text' name = 'displayEndTime' value = '<?php echo $passedEndTime ?>'  readonly>
<br>

<p>Days</p>
<input type = 'text' name = 'displayDays' value =  '<?php echo $passedDays ?>' readonly> 
<br>


<h1>These values will be deleted. Are you sure?!</h1>
<br>


<input type = 'submit' name = 'submitButton' value = 'deleteValues'>
</form>



<?php

if(isset($_POST['submitButton']))
{


	$courseID = $_POST['readOnlyCourseID'];
	$departmentName = $_POST['displayDepartment'];
	$className = $_POST['displayClassName'];
	$startTime = $_POST['displayStartTime'];
	$endTime = $_POST['displayEndTime'];
	$days = $_POST['displayDays'];


	$serverName ="localhost";
	$username= "rml3md";
	$password = "7153f64";
	$database = "rml3md";

	$link = mysqli_connect($serverName, $username, $password, $database);


	if(mysqli_connect_error())
	{
		echo "Connection Failed: " . mysqli_connect_error();
	}


	errorCheck($courseID , $className , $departmentName , $startTime , $endTime , $days);

	deleteTableValues($link ,$courseID); 


	exit(0);



}


function errorCheck($courseID , $className , $departmentName , $startTime , $endTime , $days)
{

	if($courseID == "")
	{

		echo"<p>The Course ID is not filled out.</p>";
		exit(0);

	}

	if($className == "")
	{
		echo"<p>The class Name is not filled out. </p>";
		exit(0);


	}

	if($departmentName == "")
	{
		echo"<p>The department Name is not filled out.</p>";
		exit(0);


	}

	if($startTime == "")
	{
		echo"<p>The start time is not filled out.</p>";
		exit(0);


	}



	if($endTime == "")
	{
		echo"<p>The end time is not filled out.</p>";
		exit(0);


	}



	if($days == "")
	{
		echo"<p>The days is not filled out.</p>";
		exit(0);


	}

}
function deleteTableValues($link , $courseID) 
{

	$sql = 'delete from classes  WHERE course_id = ?;';
	if ($stmt = mysqli_prepare($link, $sql))
	{
		mysqli_stmt_bind_param($stmt , "s" , $courseID)
			or die ("24");
		mysqli_stmt_execute($stmt);
		echo"<p>Table row successfully deleted!</p>";
	}
	else
	{
		echo "<p>statment failed to execute :(</p>";
	}

}



?>





</div>
</body>
</html>
