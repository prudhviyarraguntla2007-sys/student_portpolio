<?php

session_start();

include "db_connect.php";

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$student_id=$_SESSION['student_id'];

$id=$_POST['id'];
$subject=trim($_POST['subject']);
$exam_name=trim($_POST['exam_name']);
$exam_date=$_POST['exam_date'];
$exam_time=$_POST['exam_time'];
$room=trim($_POST['room']);

$sql="UPDATE exams
SET subject=?,
exam_name=?,
exam_date=?,
exam_time=?,
room=?
WHERE id=? AND student_id=?";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"sssssii",
$subject,
$exam_name,
$exam_date,
$exam_time,
$room,
$id,
$student_id
);

if(mysqli_stmt_execute($stmt))
{
    header("Location: dashboard.php");
    exit();
}
else
{
    echo mysqli_stmt_error($stmt);
}

?>