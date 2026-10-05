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

<title>Add Exam</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Add Exam</h1>

<form action="save_exam.php" method="POST">

<label>Subject</label>

<input type="text" name="subject" required>

<label>Exam Name</label>

<input type="text" name="exam_name" required>

<label>Exam Date</label>

<input type="date" name="exam_date" required>

<label>Exam Time</label>

<input type="time" name="exam_time" required>

<label>Room</label>

<input type="text" name="room">

<div class="buttons">

<button type="submit">Save</button>

<a href="dashboard.php">Cancel</a>

</div>

</form>

</div>

</div>

</body>

</html>