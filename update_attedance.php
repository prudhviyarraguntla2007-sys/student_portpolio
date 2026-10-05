<?php

session_start();

include "db_connect.php";

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$id = $_POST['id'];
$subject = trim($_POST['subject']);
$total_classes = $_POST['total_classes'];
$attended_classes = $_POST['attended_classes'];

if($attended_classes > $total_classes)
{
    die("Attended classes cannot be greater than total classes.");
}

$sql = "UPDATE attendance

SET subject=?,
total_classes=?,
attended_classes=?

WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"siiii",
$subject,
$total_classes,
$attended_classes,
$id,
$student_id
);

if(mysqli_stmt_execute($stmt))
{
    header("Location: attendance.php");
    exit();
}
else
{
    echo mysqli_stmt_error($stmt);
}

?>