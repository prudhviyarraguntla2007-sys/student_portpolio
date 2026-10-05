<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login Page</title>
</head>
<body>

<div class="login-box">

    <h1>Login</h1>

    <form action="" method="POST">

        <label>Email</label>
        <input type="email"
               name="email"
               placeholder="Enter your email"
               required>

        <label>Password</label>
        <input type="password"
               name="password"
               placeholder="Enter your password"
               required>

        <button type="submit" class="login-btn">
            Login
        </button>

    </form>

    <p>Don't have an account?</p>

    <a href="sign.php">
        <button class="create-btn">
            Create Account
        </button>
    </a>

</div>
<?php

session_start();

include "db_connect.php";

if(isset($_POST['email']) && isset($_POST['password']))
{
    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="SELECT * FROM students WHERE email=?";

    $stmt=mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt,"s",$email);

    mysqli_stmt_execute($stmt);

    $result=mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result)==1)
    {
        $row=mysqli_fetch_assoc($result);

        if(password_verify($password,$row['password']))
        {
            $_SESSION['student_id']=$row['id'];
            $_SESSION['fullname']=$row['fullname'];
            $today = date("Y-m-d");
$lastLogin = $row['last_login'];
$streak = $row['streak'];

if ($lastLogin != $today)
{
    $yesterday = date("Y-m-d", strtotime("-1 day"));

    if ($lastLogin == $yesterday)
    {
        $streak++;
    }
    else
    {
        $streak = 1;
    }

    $update = "UPDATE students
               SET streak=?, last_login=?
               WHERE id=?";

    $stmt2 = mysqli_prepare($conn, $update);

    mysqli_stmt_bind_param(
        $stmt2,
        "isi",
        $streak,
        $today,
        $row['id']
    );

    mysqli_stmt_execute($stmt2);
}

            header("Location: dashboard.php");
            exit();
        }
        else
        {
            echo "<script>alert('Incorrect Password');</script>";
        }
    }
    else
    {
        echo "<script>alert('Email does not exist');</script>";
    }
}
?>

</body>
</html>