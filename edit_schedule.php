<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$schedule_id = $_GET['id'];

$sql = "SELECT * FROM schedule
        WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $schedule_id, $student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Schedule not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Edit Schedule</title>

<link rel="stylesheet" href="schedule.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

<div class="card">

<h1>Edit Class</h1>

<form action="update_schedule.php" method="POST">

<input
type="hidden"
name="id"
value="<?php echo $row['id']; ?>">

<label>Day</label>

<select name="day" required>

<option value="Monday" <?php if($row['day']=="Monday") echo "selected"; ?>>Monday</option>

<option value="Tuesday" <?php if($row['day']=="Tuesday") echo "selected"; ?>>Tuesday</option>

<option value="Wednesday" <?php if($row['day']=="Wednesday") echo "selected"; ?>>Wednesday</option>

<option value="Thursday" <?php if($row['day']=="Thursday") echo "selected"; ?>>Thursday</option>

<option value="Friday" <?php if($row['day']=="Friday") echo "selected"; ?>>Friday</option>

<option value="Saturday" <?php if($row['day']=="Saturday") echo "selected"; ?>>Saturday</option>

</select>

<label>Subject</label>

<input
type="text"
name="subject"
value="<?php echo htmlspecialchars($row['subject']); ?>"
required>

<label>Start Time</label>

<input
type="time"
name="start_time"
value="<?php echo $row['start_time']; ?>"
required>

<label>End Time</label>

<input
type="time"
name="end_time"
value="<?php echo $row['end_time']; ?>"
required>

<label>Room</label>

<input
type="text"
name="room"
value="<?php echo htmlspecialchars($row['room']); ?>">

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