<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['student_id'];

$sql = "SELECT * FROM students WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Profile</title>

<link rel="stylesheet" href="edit_profile.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<div class="container">

<div class="profile-card">

<h1>Edit Profile</h1>

<form action="update_profile.php" method="POST" enctype="multipart/form-data">

<div class="image-section">

<img src="uploads/<?php echo $student['profile_image']; ?>" class="profile-image">

<input type="file" name="profile_image">

</div>

<div class="input-group">

<label>Full Name</label>

<input
type="text"
name="fullname"
value="<?php echo htmlspecialchars($student['fullname']); ?>"
required>

</div>

<div class="input-group">

<label>Roll Number</label>

<input
type="text"
name="rollno"
value="<?php echo htmlspecialchars($student['rollno']); ?>">

</div>

<div class="input-group">

<label>College</label>

<input
type="text"
name="college"
value="<?php echo htmlspecialchars($student['college']); ?>">

</div>

<div class="input-group">

<label>Branch</label>

<input
type="text"
name="branch"
value="<?php echo htmlspecialchars($student['branch']); ?>">

</div>

<div class="input-group">

<label>Semester</label>

<input
type="text"
name="semester"
value="<?php echo htmlspecialchars($student['semester']); ?>">

</div>

<div class="input-group">

<label>CGPA</label>

<input
type="number"
step="0.01"
name="cgpa"
value="<?php echo $student['cgpa']; ?>">

</div>
<div class="input-group">

<label>Attendance</label>

<input
type="number"
step="0.01"
name="attendance"
value="<?php echo $student['attendance']; ?>">

</div>

<div class="input-group">

<label>Email</label>

<input
type="email"
name="email"
value="<?php echo htmlspecialchars($student['email']); ?>">

</div>

<div class="input-group">

<label>Phone</label>

<input
type="text"
name="phone"
value="<?php echo htmlspecialchars($student['phone']); ?>">

</div>

<div class="input-group">

<label>Address</label>

<textarea
name="address"
rows="4"><?php echo htmlspecialchars($student['address']); ?></textarea>

</div>

<div class="buttons">

<button type="submit" class="save-btn">
<i class="fa-solid fa-floppy-disk"></i>
Save Changes
</button>

<a href="dashboard.php" class="cancel-btn">
<i class="fa-solid fa-arrow-left"></i>
Cancel
</a>

</div>

</form>

</div>

</div>

</body>

</html>