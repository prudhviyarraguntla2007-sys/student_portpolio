<?php

session_start();

include "db_connect.php";
include "reward_functions.php";
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$day = $_POST['day'];
$subject = trim($_POST['subject']);
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$room = trim($_POST['room']);

$sql = "INSERT INTO schedule
(student_id, day, subject, start_time, end_time, room)
VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Prepare Error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "isssss",
    $student_id,
    $day,
    $subject,
    $start_time,
    $end_time,
    $room
);

if(mysqli_stmt_execute($stmt))
{
    addXP($conn, $student_id, 5);

    header("Location: dashboard.php");
    exit();
} else {

    echo "Execute Error: " . mysqli_stmt_error($stmt);

}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>