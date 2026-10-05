<?php

session_start();

include "db_connect.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$id = $_POST['id'];
$day = $_POST['day'];
$subject = trim($_POST['subject']);
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$room = trim($_POST['room']);

// Verify that this schedule belongs to the logged-in student
$check = "SELECT id FROM schedule WHERE id=? AND student_id=?";
$stmt = mysqli_prepare($conn, $check);

mysqli_stmt_bind_param($stmt, "ii", $id, $student_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("Unauthorized Access");
}

// Update the schedule
$sql = "UPDATE schedule
SET day=?,
    subject=?,
    start_time=?,
    end_time=?,
    room=?
WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssssii",
    $day,
    $subject,
    $start_time,
    $end_time,
    $room,
    $id,
    $student_id
);

if (mysqli_stmt_execute($stmt)) {

    header("Location: dashboard.php");
    exit();

} else {

    echo "Update Failed : " . mysqli_stmt_error($stmt);

}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>