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
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Attendance</title>

<link rel="stylesheet" href="crud.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<div class="container">

<div class="card">

<div class="schedule-header">

<h1>Attendance</h1>

<a href="add_attendance.php" class="add-class">

<i class="fa-solid fa-plus"></i>

Add Attendance

</a>

</div>

<table>

<tr>

<th>Subject</th>

<th>Total Classes</th>

<th>Attended</th>

<th>Attendance %</th>

<th>Action</th>

</tr>

<?php

$sql = "SELECT * FROM attendance
        WHERE student_id=?
        ORDER BY subject";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result))
{

if($row['total_classes']>0)
{
    $percentage =
    round(($row['attended_classes']/$row['total_classes'])*100,2);
}
else
{
    $percentage = 0;
}

?>

<tr>

<td><?php echo htmlspecialchars($row['subject']); ?></td>

<td><?php echo $row['total_classes']; ?></td>

<td><?php echo $row['attended_classes']; ?></td>

<td><?php echo $percentage; ?>%</td>

<td>

<a class="edit-btn"
href="edit_attendance.php?id=<?php echo $row['id']; ?>">

Edit

</a>

<a class="delete-btn"
href="delete_attendance.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this record?');">

Delete

</a>

</td>

</tr>

<?php
}
?>

</table>

<br>

<a href="dashboard.php" class="add-class">

<i class="fa-solid fa-arrow-left"></i>

Back to Dashboard

</a>

</div>

</div>

</body>

</html>