<?php

session_start();

include "db_connect.php";
include "reward_functions.php";
if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$subject = trim($_POST['subject']);
$total_classes = $_POST['total_classes'];
$attended_classes = $_POST['attended_classes'];

/* Validation */

if($attended_classes > $total_classes)
{
    die("Attended classes cannot be greater than total classes.");
}

$sql = "INSERT INTO attendance
(student_id, subject, total_classes, attended_classes)
VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
$stmt,
"isii",
$student_id,
$subject,
$total_classes,
$attended_classes
);

if(mysqli_stmt_execute($stmt))
{
    addXP($conn, $student_id, 10);

    header("Location: dashboard.php");
    exit();
}
else
{
    echo "Error : " . mysqli_stmt_error($stmt);
}

?>