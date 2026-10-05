<?php

session_start();
include "db_connect.php";
include "reward_functions.php";
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$id = $_GET['id'];

$sql = "SELECT * FROM homework
        WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $id, $student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Homework not found.");
}
$sql = "SELECT status
        FROM homework
        WHERE id = ? AND student_id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $id, $student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$oldHomework = mysqli_fetch_assoc($result);

$oldStatus = $oldHomework['status'];
$sql = "UPDATE homework
        SET subject=?,
            title=?,
            due_date=?,
            status=?
        WHERE id=? AND student_id=?";

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Homework</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Edit Homework</h1>

<form action="update_homework.php" method="POST">

<input type="hidden" name="id"
value="<?php echo $row['id']; ?>">

<label>Subject</label>

<input
type="text"
name="subject"
value="<?php echo htmlspecialchars($row['subject']); ?>"
required>

<label>Homework Title</label>

<input
type="text"
name="title"
value="<?php echo htmlspecialchars($row['title']); ?>"
required>

<label>Due Date</label>

<input
type="date"
name="due_date"
value="<?php echo $row['due_date']; ?>"
required>

<label>Status</label>

<select name="status">

<option value="Pending"
<?php if($row['status']=="Pending") echo "selected"; ?>>
Pending
</option>

<option value="Completed"
<?php if($row['status']=="Completed") echo "selected"; ?>>
Completed
</option>

</select>

<div class="buttons">

<button type="submit">
Update
</button>

<a href="dashboard.php">
Cancel
</a>

</div>

</form>

</div>

</div>

</body>

</html>