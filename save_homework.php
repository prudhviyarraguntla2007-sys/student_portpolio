<?php

session_start();

include "db_connect.php";
include "reward_functions.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$subject = trim($_POST['subject']);
$title = trim($_POST['title']);
$due_date = $_POST['due_date'];
$status = $_POST['status'];

$sql = "INSERT INTO homework
(student_id, subject, title, due_date, status)
VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "issss",
    $student_id,
    $subject,
    $title,
    $due_date,
    $status
);

if(mysqli_stmt_execute($stmt))
{
   addXP($conn, $student_id, 10);

header("Location: dashboard.php");
exit();
} else {

   echo "Error : " . mysqli_stmt_error($stmt);

}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?> 