<?php

session_start();

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Attendance</title>

<link rel="stylesheet" href="crud.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Add Attendance</h1>

<form action="save_attendance.php" method="POST">

<label>Subject</label>

<input
type="text"
name="subject"
placeholder="Enter Subject Name"
required>

<label>Total Classes</label>

<input
type="number"
name="total_classes"
min="0"
required>

<label>Attended Classes</label>

<input
type="number"
name="attended_classes"
min="0"
required>

<div class="buttons">

<button type="submit">

Save Attendance

</button>

<a href="attendance.php">

Cancel

</a>

</div>

</form>

</div>

</div>

</body>

</html>