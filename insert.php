<!DOCTYPE html>

<html lang = "en"> 

<head>

<title>Insert Lab 10</title>

<meta charset = "UTF-8">


<!--  I USE BOOTSTRAP BECAUSE IT MAKES FORMATTING/LIFE EASIER -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"><!-- Optional theme -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->

<style>

div
{
text-align:center;

}

a
{

font-size:20px;

}


</style>


</head>



<body>
<a href="http://cs3380.rnet.missouri.edu/~rml3md/lab9/lab9.php">Home</a>
<!--
<hr>
<form action="" method="POST" class="col-md-4 col-md-offset-5">
Name: 
<input type="text" name="uName"></br></br>
<input class="btn btn-primary" type="submit" name="submit" value="Create New User"> -->

<form method = "POST" name = "form">


<div>

Class Name 
<br>
<input type = "text" name = "className">
<br>


Department
<br>
<input type = "text" name = "department">
<br>


Course ID
<br>
<input type = "text" name = "courseID">
<br>




Start Time
<br>
<select name = "Start">
<option selected value = "08:00:00">08:00:00</option>
<option value = "09:00:00">09:00:00</option>
<option value = "09:30:00">09:30:00</option>
<option value = "10:00:00">10:00:00</option>
<option value = "11:00:00">11:00:00</option>
<option value = "12:00:00">12:00:00</option>
<option value = "12:30:00">12:30:00</option>
<option value = "13:00:00">13:00:00</option>
<option value = "14:00:00">14:00:00</option>
<option value = "15:30:00">15:30:00</option>
<option value = "16:00:00">16:00:00</option>
</select>
<br>

End Time
<br>
<select name = "End">
<option selected value = "08:50:00">08:50:00</option>
<option value = "09:15:00">9:15:00</option>
<option value = "09:50:00">9:50:00</option>
<option value = "10:00:00">10:45:00</option>
<option value = "10:50:00">10:50:00</option>
<option value = "11:50:00">11:50:00</option>
<option value = "12:15:00">12:15:00</option>
<option value = "12:50:00">12:50:00</option>
<option value = "13:50:00">13:50:00</option>
<option value = "14:50:00">14:50:00</option>
<option value = "15:15:00">15:15:00</option>
<option value = "15:50:00">15:50:00</option>
<option value = "16:45:00">16:45:00</option>
<option value = "16:50:00">16:50:00</option>
</select>

<br>

Days Offered

<br>
<select name = "daysOffered">
<option selected value = "MWF">MWF</option>
<option value = "TuTh">TuTh</option>
</select>
<br>

<input type = "submit" name = "submit" style = "margin-top : 10px">
</form>

</div>
</html>



<?php

if(isset($_POST['submit']))
{

	$link = mysqli_connect('localhost' , 'rml3md' , '7153f64' , 'rml3md') or die ( " line 128" . mysqli_connect_error());

	$sql = 'INSERT INTO classes (name, department, course_id, start, end, day) VALUES (?, ?, ?, ?, ?, ?)';


	if($stmt = mysqli_prepare($link , $sql))
	{

		mysqli_stmt_bind_param($stmt , 'ssssss' , $_POST['className'] , $_POST['department'], $_POST['courseID'] , $_POST['Start']  , $_POST['End']  , $_POST['daysOffered']) or die ("26");

		$startTime = $_POST['Start'];
		$endTime = $_POST['End'];	
		$className = $_POST['className'];
		$department = $_POST['department'];
		$courseID = $_POST['courseID'];
			
		
		if($startTime > $endTime)
		{
			echo "<div><p>Your times are invalid!</p></div>";	
			exit(0);

		}

		if($department == "" || $courseID == "" || $className == "")
		{
			echo "<div><p>You forgot to file out a field! Uh Oh!</div></p>";
			exit(0);

		}


		if(mysqli_stmt_execute($stmt))
		{
			echo "<div><p>class successfully inserted</p></div>";

		}
		
		else
		{
			echo "<div><p>statement failed to execute.Check if you are inserting a duplicate Course ID.</p></div>";

		}
	}

}


?>
