<?php

session_start();
include "db_connect.php";

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Performance</title>

<link rel="stylesheet" href="dashboard.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<div class="container">

<div class="student-info">

<div class="schedule-header">

<h2>Performance</h2>

<a href="add_performance.php" class="add-class">

<i class="fa-solid fa-plus"></i>

Add Performance

</a>

</div>

<table>

<tr>

<th>Semester</th>

<th>Subject</th>

<th>Marks</th>

<th>Grade</th>

<th>CGPA</th>

<th>Action</th>

</tr>

<?php

$sql="SELECT * FROM performance
WHERE student_id=?
ORDER BY semester ASC";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$student_id);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['semester']; ?></td>

<td><?php echo htmlspecialchars($row['subject']); ?></td>

<td><?php echo $row['marks']; ?></td>

<td><?php echo htmlspecialchars($row['grade']); ?></td>

<td><?php echo $row['cgpa']; ?></td>

<td>

<a href="edit_performance.php?id=<?php echo $row['id']; ?>" class="edit-btn">

<i class="fa-solid fa-pen"></i>

</a>

<a href="delete_performance.php?id=<?php echo $row['id']; ?>"
class="delete-btn"
onclick="return confirm('Delete this record?');">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

</body>

</html>