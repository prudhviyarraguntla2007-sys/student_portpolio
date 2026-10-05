<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['student_id'];

// Get form data
$fullname   = trim($_POST['fullname']);
$rollno     = trim($_POST['rollno']);
$college    = trim($_POST['college']);
$branch     = trim($_POST['branch']);
$semester   = trim($_POST['semester']);
$cgpa       = $_POST['cgpa'];
$attendance = $_POST['attendance'];
$email      = trim($_POST['email']);
$phone      = trim($_POST['phone']);
$address    = trim($_POST['address']);

// Get current profile image
$sql = "SELECT profile_image FROM students WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$profile_image = $row['profile_image'];

// Upload new image (if selected)
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {

    $allowed = array("jpg","jpeg","png");

    $filename = $_FILES['profile_image']['name'];
    $tmpname  = $_FILES['profile_image']['tmp_name'];
    $size     = $_FILES['profile_image']['size'];

    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (in_array($extension, $allowed)) {

        if ($size <= 2 * 1024 * 1024) {

            $newname = "profile_" . $id . "_" . time() . "." . $extension;

            if (!is_dir("uploads")) {
                mkdir("uploads", 0777, true);
            }

            move_uploaded_file($tmpname, "uploads/" . $newname);

            // Delete old image (except default)
            if ($profile_image != "default.png" && file_exists("uploads/" . $profile_image)) {
                unlink("uploads/" . $profile_image);
            }

            $profile_image = $newname;

        } else {
            die("Image size should be less than 2 MB.");
        }

    } else {
        die("Only JPG, JPEG and PNG images are allowed.");
    }
}

// Update database
$sql = "UPDATE students SET
fullname=?,
rollno=?,
college=?,
branch=?,
semester=?,
cgpa=?,
attendance=?,
email=?,
phone=?,
address=?,
profile_image=?
WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssssddssssi",
    $fullname,
    $rollno,
    $college,
    $branch,
    $semester,
    $cgpa,
    $attendance,
    $email,
    $phone,
    $address,
    $profile_image,
    $id
);

if (mysqli_stmt_execute($stmt)) {

    header("Location: dashboard.php");
    exit();

} else {

    echo "Error updating profile.";

}
?>