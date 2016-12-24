<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lab9</title>

<style>

table
{
width: 100%;
	   border-collapse:collapse;
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

a
{

	font-size:20px;

}




</style>
</head>
<body>
<form method="POST">
<input type="text" name="searchBar" value=""><br>
<input type="radio" name="checkBox" value="name">Name<br>
<input type="radio" name="checkBox" value="department">Department <br>
<input type="radio" name="checkBox" value="course_id">Course_ID<br>
<input type = "submit" name = "submit" >
</form>




<a href="http://cs3380.rnet.missouri.edu/~rml3md/lab9/insert.php">Insert Into User</a>

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

mysqli_query($link, "USE rml3md");

checkError();

$nameOfSearch = $_POST['checkBox'];

echo "You made a $nameOfSearch search!";

$sql = "";
if ($nameOfSearch == "course_id")
{
	$sql =  searchByCourseID();
}

if ($nameOfSearch == "department")
{
	$sql =  searchByDepartment();
}


if ($nameOfSearch == "name")
{
	$sql =  searchByName();
}

$result = mysqli_query($link, $sql);
printTable($result);


function searchByCourseID()
{

	$sql = "SELECT * FROM classes WHERE course_id LIKE '"  . $_POST['searchBar'] . "%';";
	return $sql;
}

function searchByDepartment()
{

	$sql = "SELECT * FROM classes WHERE department LIKE '"  . $_POST['searchBar'] . "%';";


	return $sql;

}


function searchByName()
{

	$sql = "SELECT * FROM classes WHERE name LIKE '"  . $_POST['searchBar'] . "%';";


	return $sql;

}
function checkError()
{


	if(!isset($_POST['searchBar']) || $_POST['searchBar'] == "")
	{
		echo "Your search was empty!";
		exit(0);

	}
	if(!isset($_POST['checkBox']))
	{
		echo "No checkbox was selected!";
		exit(0);

	}
	if(!isset($_POST['submit']))
	{
		echo "No submission was made!";
		echo(0);
	}



}
function printTable($result)
{


	echo "<table>";	

	while($field = mysqli_fetch_field($result))
	{
		echo "<th>";
		echo $field->name . "<br>";
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
		$counter = 0;
		$updateName = "update";
		foreach($row as $value)
		{
			echo "<td>";
			echo $value . "<br>";
			echo "</td>\n";
			$counter++;
		}
		echo "<td>";
		echo "<form>";
		echo "<input type= 'submit' name='update$counter' value='Update'>";
		echo "</form";
		echo "</td>";
		echo "<td>";
		echo "<form>";
		echo "<input type= 'submit' name='delete$counter' value='Delete'>";
		echo "</form";
		echo "</td>";
		echo "</tr>\n";

	}


		echo "</table>";

}




?>
