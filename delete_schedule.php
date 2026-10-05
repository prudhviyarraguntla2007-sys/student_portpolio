<?php

session_start();
include "db_connect.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

if (!isset($_GET['id'])) {
    die("Invalid Request");
}

$id = $_GET['id'];

$sql = "DELETE FROM schedule
        WHERE id=? AND student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ii", $id, $student_id);

if (mysqli_stmt_execute($stmt)) {

    header("Location: dashboard.php");
    exit();

} else {

    echo "Delete Failed";

}

?>