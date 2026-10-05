<?php

session_start();

include "db_connect.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

/* Check if new passwords match */

if ($new_password != $confirm_password) {
    die("New passwords do not match.");
}

/* Get current password from database */

$sql = "SELECT password
        FROM students
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $student_id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

/* Verify current password */

if (!password_verify($current_password, $user['password'])) {
    die("Current password is incorrect.");
}

/* Hash new password */

$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

/* Update password */

$sql = "UPDATE students
        SET password = ?
        WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "si", $new_hash, $student_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error updating password.";
}

?>