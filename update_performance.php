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
$semester = $_POST['semester'];
$subject = trim($_POST['subject']);
$marks = $_POST['marks'];
$grade = trim($_POST['grade']);
$cgpa = $_POST['cgpa'];

$sql = "UPDATE performance
SET semester=?,
subject=?,
marks=?,
grade=?,
cgpa=?
WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
$stmt,
"isidsii",
$semester,
$subject,
$marks,
$grade,
$cgpa,
$id,
$student_id
);

if(mysqli_stmt_execute($stmt))
{
    header("Location: performance.php");
    exit();
}
else
{
    echo mysqli_stmt_error($stmt);
}

?>