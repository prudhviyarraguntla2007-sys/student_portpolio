<?php
session_start();

if(!isset($_SESSION['student_id']))
{
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Schedule</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Add Class</h1>

<form action="save_schedule.php" method="POST">

<label>Day</label>

<select name="day" required>

<option value="">Select Day</option>

<option>Monday</option>

<option>Tuesday</option>

<option>Wednesday</option>

<option>Thursday</option>

<option>Friday</option>

<option>Saturday</option>

</select>

<label>Subject</label>

<input type="text" name="subject" required>

<label>Start Time</label>

<input type="time" name="start_time" required>

<label>End Time</label>

<input type="time" name="end_time" required>

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