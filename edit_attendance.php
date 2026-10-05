<?php

session_start();

include "db_connect.php";

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$id = $_GET['id'];

$sql = "SELECT * FROM attendance
        WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"ii",$id,$student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if(!$row)
{
    die("Attendance record not found.");
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Attendance</title>

<link rel="stylesheet" href="crud.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Edit Attendance</h1>

<form action="update_attendance.php" method="POST">

<input
type="hidden"
name="id"
value="<?php echo $row['id']; ?>">

<label>Subject</label>

<input
type="text"
name="subject"
value="<?php echo htmlspecialchars($row['subject']); ?>"
required>

<label>Total Classes</label>

<input
type="number"
name="total_classes"
value="<?php echo $row['total_classes']; ?>"
required>

<label>Attended Classes</label>

<input
type="number"
name="attended_classes"
value="<?php echo $row['attended_classes']; ?>"
required>

<div class="buttons">

<button type="submit">

Update Attendance

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