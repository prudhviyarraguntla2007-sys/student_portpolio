<?php

include "db_connect.php";

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

if($password != $confirm)
{
    die("Passwords do not match");
}

$sql = "SELECT * FROM students WHERE email=?";

$stmt = mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt,"s",$email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result)>0)
{
    die("Email already exists");
}

$hash = password_hash($password,PASSWORD_DEFAULT);

$sql = "INSERT INTO students
(
fullname,
rollno,
college,
branch,
semester,
cgpa,
attendance,
email,
phone,
address,
password,
profile_image,
streak,
points,
last_login
)

VALUES
(
?,
'',
'',
'',
1,
0.00,
0.00,
?,
'',
'',
?,
'default.png',
1,
0,
CURDATE()
)";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$hash);

if(mysqli_stmt_execute($stmt))
{
    $newStudentId = mysqli_insert_id($conn);

$sql = "INSERT INTO rewards (student_id, level, xp, badge)
VALUES (?, 1, 0, 'Beginner')";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $newStudentId);

mysqli_stmt_execute($stmt);
    header("Location: login.php");
    exit();
}
else
{
    echo "Registration Failed";
}
?>