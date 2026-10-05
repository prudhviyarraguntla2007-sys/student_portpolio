<?php

session_start();

include "db_connect.php";
include "reward_functions.php";

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$student_id=$_SESSION['student_id'];

$subject=trim($_POST['subject']);
$exam_name=trim($_POST['exam_name']);
$exam_date=$_POST['exam_date'];
$exam_time=$_POST['exam_time'];
$room=trim($_POST['room']);

$sql="INSERT INTO exams
(student_id,subject,exam_name,exam_date,exam_time,room)
VALUES(?,?,?,?,?,?)";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"isssss",
$student_id,
$subject,
$exam_name,
$exam_date,
$exam_time,
$room
);

if(mysqli_stmt_execute($stmt))
{
    addXP($conn, $student_id, 5);

    header("Location: dashboard.php");
    exit();
}
else
{
    echo mysqli_stmt_error($stmt);
}

?>