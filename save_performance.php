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

$semester=$_POST['semester'];
$subject=trim($_POST['subject']);
$marks=$_POST['marks'];
$grade=trim($_POST['grade']);
$cgpa=$_POST['cgpa'];

$sql="INSERT INTO performance
(student_id,semester,subject,marks,grade,cgpa)
VALUES(?,?,?,?,?,?)";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"iisisd",
$student_id,
$semester,
$subject,
$marks,
$grade,
$cgpa
);

if(mysqli_stmt_execute($stmt))
{
    addXP($conn, $student_id, 15);

    header("Location: dashboard.php");
    exit();
}
else
{
    echo mysqli_stmt_error($stmt);
}

?>