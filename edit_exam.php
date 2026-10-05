<?php

session_start();
include "db_connect.php";

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$student_id=$_SESSION['student_id'];

$id=$_GET['id'];

$sql="SELECT * FROM exams
WHERE id=? AND student_id=?";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"ii",$id,$student_id);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

$row=mysqli_fetch_assoc($result);

if(!$row)
{
    die("Exam not found.");
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Exam</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Edit Exam</h1>

<form action="update_exam.php" method="POST">

<input type="hidden" name="id"
value="<?php echo $row['id']; ?>">

<label>Subject</label>

<input
type="text"
name="subject"
value="<?php echo htmlspecialchars($row['subject']); ?>"
required>

<label>Exam Name</label>

<input
type="text"
name="exam_name"
value="<?php echo htmlspecialchars($row['exam_name']); ?>"
required>

<label>Exam Date</label>

<input
type="date"
name="exam_date"
value="<?php echo $row['exam_date']; ?>"
required>

<label>Exam Time</label>

<input
type="time"
name="exam_time"
value="<?php echo $row['exam_time']; ?>"
required>

<label>Room</label>

<input
type="text"
name="room"
value="<?php echo htmlspecialchars($row['room']); ?>">

<div class="buttons">

<button type="submit">Update</button>

<a href="dashboard.php">Cancel</a>

</div>

</form>

</div>

</div>

</body>

</html>