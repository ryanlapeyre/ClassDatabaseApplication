<!DOCTYPE html>
<!--
Ryan Lapeyre
rml3md/16156898
Lab10 
11/12/16 -->


<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lab10</title>

<style>

table
{
width: 100%;
	   border-collapse:collapse;

}

input[type=text] {
width: 100%;
padding: 12px 20px;
margin: 8px 0;
		box-sizing: border-box;
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

th , td  
{
	font-size: 20px;
padding : 10px;
		  border-bottom: 1px solid black;
		  text-align: left;
}

th
{
height: 50px;
}

a , p
{
	text-align:left;
	font-size:20px;
}

div
{

	text-align:left;
}
<div>


</style>
</head>
<body>
<div>
<form method="POST">
<input type="text" name="searchBar" value=""><br>
<input type="radio" name="checkBox" value="name">Name<br>
<input type="radio" name="checkBox" value="department">Department<br>
<input type="radio" name="checkBox" value="course_id">Course_ID<br>
<input type = "submit" name = "submit"> <br>
<input type = "submit" name = "ViewAll" value = "ViewAll">
</form>




<a href="http://cs3380.rnet.missouri.edu/~rml3md/lab9/insert.php">Insert Into User</a>
</div>
</body>

</html>


<?php
$serverName ="localhost";
$username= "rml3md";
$password = "7153f64";
$database = "rml3md";

$link = mysqli_connect($serverName, $username, $password, $database);


if(mysqli_connect_error())
{
	echo "Connection Failed: " . mysqli_connect_error();
}
//mysqli_query($conn, "USE rml3md");

if(isset($_POST['ViewAll']))
{

	searchByAll($link);
	exit(0);
}

checkError();
$nameOfSearch = $_POST['checkBox'];

echo "<p>You made a $nameOfSearch search!</p>";

$sql = "";
if ($nameOfSearch == "course_id")
{
	$sql =  searchByCourseID($link);
}

if ($nameOfSearch == "department")
{
	$sql =  searchByDepartment($link);
}


if ($nameOfSearch == "name")
{
	$sql =  searchByName($link);
}


function searchByCourseID($link)
{

	$sql = 'SELECT * FROM classes WHERE course_id LIKE concat(? , "%");';
	if ($stmt = mysqli_prepare($link, $sql))
	{
		mysqli_stmt_bind_param($stmt , "s" , $_POST['searchBar'] ) or die ("24");
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	}

	printTable($result);

	clearQuery($result);

}

function searchByDepartment($link)
{


	$sql = 'SELECT * FROM classes WHERE department LIKE concat(? , "%");';
	if ($stmt = mysqli_prepare($link, $sql))
	{
		mysqli_stmt_bind_param($stmt , "s" , $_POST['searchBar'] ) or die ("24");
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	}

	printTable($result);
	clearQuery($result);
}


function searchByName($link)
{

	$sql = 'SELECT * FROM classes WHERE name LIKE concat(? , "%");';
	if ($stmt = mysqli_prepare($link, $sql))
	{
		mysqli_stmt_bind_param($stmt , "s" , $_POST['searchBar'] ) or die ("24");
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	}

	printTable($result);
	clearQuery($result);


}


function searchByAll($link)
{

	$sql = 'SELECT * FROM classes;';
	if ($stmt = mysqli_prepare($link, $sql))
	{
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
	}

	printTable($result);
	clearQuery($result);

}
function checkError()
{

	if(!isset($_POST['searchBar']) || $_POST['searchBar'] == "")
	{
		echo "<p>Your search was empty!</p>";
		exit(0);

	}
	if(!isset($_POST['checkBox']))
	{
		echo "<p>No checkbox was selected!</p>";
		exit(0);

	}
	if(!isset($_POST['submit']))
	{
		echo "<p>No submission was made!</p>";
		exit(0);
	}


}
function printTable($result)
{


	echo "<table>";	

	while($field = mysqli_fetch_field($result))
	{
		echo "<th>";
		echo $field->name;
		echo "</th>";
	}
	$updateRowName = "update";
	$deleteRowName = "delete";
	echo "<th>";
	echo "$updateRowName";
	echo "</th>";
	echo "<th>";
	echo "$deleteRowName";
	echo "</th>";

	while($row = mysqli_fetch_row($result))
	{
		echo "<tr>";
		foreach($row as $value)
		{
			echo "<td>";
			echo $value;
			echo "</td>";
		}
		echo "<td>";
		echo '<form action = "update.php" method = "POST">';
		echo "<input type = 'hidden' name = 'updateClassName' value = '$row[0]'>";
		echo "<input type = 'hidden' name = 'updateDepartmentName' value = '$row[1]'>";
		echo "<input type = 'hidden' name = 'updateCourseID' value = '$row[2]'>";
		echo "<input type = 'hidden' name = 'updateStartTime' value = '$row[3]'>";
		echo "<input type = 'hidden' name = 'updateEndTime' value = '$row[4]'>";
		echo "<input type = 'hidden' name = 'updateDays' value = '$row[5]'>";
		echo '<input type= "submit" name="update" value="Update">';
		echo "</form>";
		echo "</td>";
	
		echo "<td>";
		echo '<form action = "delete.php" method = "POST">';
		echo "<input type = 'hidden' name = 'deleteClassName' value = '$row[0]'>";
		echo "<input type = 'hidden' name = 'deleteDepartmentName' value = '$row[1]'>";
		echo "<input type = 'hidden' name = 'deleteCourseID' value = '$row[2]'>";
		echo "<input type = 'hidden' name = 'deleteStartTime' value = '$row[3]'>";
		echo "<input type = 'hidden' name = 'deleteEndTime' value = '$row[4]'>";
		echo "<input type = 'hidden' name = 'deleteDays' value = '$row[5]'>";
		echo "<input type= 'submit' name='delete' value='Delete'>";
		echo "</form>";
		echo "</td>";
	
		echo "</tr>";

	}


	echo "</table>";

}


function clearQuery($result)
{
	mysqli_free_result($result);

}



?>
