<!DOCTYPE html>
<html>
<head>

<title>Create Account</title>

<link rel="stylesheet" href="sign.css">

</head>

<body>

<div class="container">

<form action="register.php" method="POST">

<h2>Create Account</h2>

<input type="text"
name="fullname"
placeholder="Full Name"
required>

<input type="email"
name="email"
placeholder="Email"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<input type="password"
name="confirm_password"
placeholder="Confirm Password"
required>

<button type="submit">

Create Account

</button>

<p>

Already have an account?

<a href="login.php">

Login

</a>

</p>

</form>

</div>


</body>

</html>