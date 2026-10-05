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
    <title>Change Password</title>

    <link rel="stylesheet" href="schedule.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="container">

<div class="card">

<h1>Change Password</h1>

<form action="update_password.php" method="POST">

<label>Current Password</label>
<input type="password" name="current_password" required>

<label>New Password</label>
<input type="password" name="new_password" required>

<label>Confirm New Password</label>
<input type="password" name="confirm_password" required>

<div class="buttons">

<button type="submit">Update Password</button>

<a href="dashboard.php">Cancel</a>

</div>

</form>

</div>

</div>

</body>
</html>