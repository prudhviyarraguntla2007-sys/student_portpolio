<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Add Homework</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Add Homework</h1>

<form action="save_homework.php" method="POST">

<label>Subject</label>

<input type="text" name="subject" required>

<label>Homework Title</label>

<input type="text" name="title" required>

<label>Due Date</label>

<input type="date" name="due_date" required>

<label>Status</label>

<select name="status">

<option value="Pending">Pending</option>

<option value="Completed">Completed</option>

</select>

<div class="buttons">

<button type="submit">Save</button>

<a href="dashboard.php">Cancel</a>

</div>

</form>

</div>

</div>

</body>

</html>