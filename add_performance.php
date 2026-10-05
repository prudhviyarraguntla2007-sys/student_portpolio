<?php

session_start();

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Add Performance</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Add Performance</h1>

<form action="save_performance.php" method="POST">

<label>Semester</label>

<input type="number" name="semester" min="1" max="8" required>

<label>Subject</label>

<input type="text" name="subject" required>

<label>Marks</label>

<input type="number" name="marks" min="0" max="100" required>

<label>Grade</label>

<input type="text" name="grade" maxlength="2" required>

<label>CGPA</label>

<input type="number" step="0.01" min="0" max="10" name="cgpa" required>

<div class="buttons">

<button type="submit">Save</button>

<a href="performance.php">Cancel</a>

</div>

</form>

</div>

</div>

</body>

</html>