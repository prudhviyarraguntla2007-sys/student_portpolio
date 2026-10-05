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

$sql = "SELECT * FROM performance
        WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $id, $student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if(!$row)
{
    die("Record not found.");
}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Performance</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Edit Performance</h1>

<form action="update_performance.php" method="POST">

<input type="hidden" name="id"
value="<?php echo $row['id']; ?>">

<label>Semester</label>

<input type="number"
name="semester"
value="<?php echo $row['semester']; ?>"
required>

<label>Subject</label>

<input type="text"
name="subject"
value="<?php echo htmlspecialchars($row['subject']); ?>"
required>

<label>Marks</label>

<input type="number"
name="marks"
value="<?php echo $row['marks']; ?>"
required>

<label>Grade</label>

<input type="text"
name="grade"
value="<?php echo htmlspecialchars($row['grade']); ?>"
required>

<label>CGPA</label>

<input type="number"
step="0.01"
name="cgpa"
value="<?php echo $row['cgpa']; ?>"
required>

<div class="buttons">

<button type="submit">Update</button>

<a href="performance.php">Cancel</a>

</div>

</form>

</div>

</div>

</body>

</html>