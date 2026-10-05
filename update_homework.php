<?php

session_start();

include "db_connect.php";
include "reward_functions.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$id = $_POST['id'];
$subject = trim($_POST['subject']);
$title = trim($_POST['title']);
$due_date = $_POST['due_date'];
$status = $_POST['status'];

/* Get the current status before updating */

$sql = "SELECT status
        FROM homework
        WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $id, $student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$homework = mysqli_fetch_assoc($result);

$oldStatus = $homework['status'];

/* Update homework */

$sql = "UPDATE homework
SET subject=?,
    title=?,
    due_date=?,
    status=?
WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssii",
    $subject,
    $title,
    $due_date,
    $status,
    $id,
    $student_id
);

if(mysqli_stmt_execute($stmt))
{
    // Award XP only once when changing from Pending to Completed
    if($oldStatus == "Pending" && $status == "Completed")
    {
        addXP($conn, $student_id, 20);
    }

    header("Location: dashboard.php");
    exit();
}
else
{
    echo "Update Failed : " . mysqli_stmt_error($stmt);
}

?>