<?php

session_start();

include "db_connect.php";

if(!isset($_SESSION['student_id']))
{
    header("Location: login.php");
    exit();
}

$id=$_SESSION['student_id'];

$sql="SELECT * FROM students WHERE id=?";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

$student=mysqli_fetch_assoc($result);

if(!$student)
{
    die("Student not found.");
}

$studentName=$student['fullname'];
$cgpa=$student['cgpa'];
$attendance=$student['attendance'];
$points=$student['points'];
$streak=$student['streak'];
$sql = "SELECT
SUM(total_classes) AS total,
SUM(attended_classes) AS attended
FROM attendance
WHERE student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$attendanceData = mysqli_fetch_assoc($result);

$totalClasses = $attendanceData['total'];
$attendedClasses = $attendanceData['attended'];

$attendancePercentage = 0;

if($totalClasses > 0)
{
    $attendancePercentage =
    round(($attendedClasses/$totalClasses)*100,2);
}
$sql = "SELECT subject, MAX(marks) AS highest_marks
        FROM performance
        WHERE student_id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$highest = mysqli_fetch_assoc($result);

$highestMarks = $highest['highest_marks'] ?? 0;
$highestSubject = $highest['subject'] ?? "-";
$sql = "SELECT AVG(marks) AS average_marks
        FROM performance
        WHERE student_id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$avg = mysqli_fetch_assoc($result);

$averageMarks = round($avg['average_marks'],2);
$sql = "SELECT subject,
ROUND((attended_classes*100)/total_classes,2) AS percentage

FROM attendance

WHERE student_id=?

ORDER BY percentage DESC

LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$bestAttendance = mysqli_fetch_assoc($result);

$bestPercentage = $bestAttendance['percentage'] ?? 0;

$bestSubject = $bestAttendance['subject'] ?? "-";
$sql = "SELECT COUNT(*) AS total_subjects

FROM performance

WHERE student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$total = mysqli_fetch_assoc($result);

$totalSubjects = $total['total_subjects'] ?? 0;
$sql = "SELECT * FROM rewards
WHERE student_id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$reward = mysqli_fetch_assoc($result);

if($reward)
{
    $xp = $reward['xp'];
    $level = $reward['level'];
    $badge = $reward['badge'];
}
else
{
    $xp = 0;
    $level = 1;
    $badge = "Beginner";
}
$sql = "SELECT COUNT(*) AS pending_assignments
        FROM homework
        WHERE student_id=? AND status='Pending'";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$assignment = mysqli_fetch_assoc($result);

$totalAssignments = $assignment['pending_assignments'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>

    <link rel="stylesheet" href="dashboard.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<div class="container">

    <!-- Sidebar -->

    <aside class="sidebar">

        <h2 class="logo">🎓 Student</h2>

        <ul>
            
            <ul>
<li>
    <a href="#dashboard" class="sidebar-link">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>
</li>

<li>
    <a href="#schedule" class="sidebar-link">
        <i class="fa-solid fa-calendar"></i>
        Schedule
    </a>
</li>

<li>
    <a href="#homework" class="sidebar-link">
        <i class="fa-solid fa-book"></i>
        Homework
    </a>
</li>

<li>
    <a href="#exams" class="sidebar-link">
        <i class="fa-solid fa-file"></i>
        Exams
    </a>
</li>

<li>
    <a href="#rewards" class="sidebar-link">
        <i class="fa-solid fa-trophy"></i>
        Rewards
    </a>
</li>

<li>
    <a href="#streak" class="sidebar-link">
        <i class="fa-solid fa-star"></i>
        Login Streak
    </a>
</li>

    <hr>

    <li>
        <a href="change_password.php" class="sidebar-link">
            <i class="fa-solid fa-key"></i>
            Change Password
        </a>
    </li>

    <li>
        <a href="logout.php" class="sidebar-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>
    </li>

</ul>

    </aside>

    <!-- Main Content -->

    <main class="main">

        <!-- Navbar -->

        <div class="navbar">

            <h1>Welcome, <?php echo $studentName; ?> 👋</h1>

            <div class="icons">

                <i class="fa-solid fa-bell"></i>

                <i class="fa-solid fa-gear"></i>

             <a href="edit_profile.php">
    <img src="uploads/<?php echo htmlspecialchars($student['profile_image']); ?>"
         style="width:45px;height:45px;border-radius:50%;object-fit:cover;">
</a>


            </div>

        </div>

        <!-- Statistics -->

        <div class="cards">

            <div class="card">

                <h3>CGPA</h3>

                <h2><?php echo $cgpa; ?></h2>

            </div>

          

            <div class="card">

                <h3>Assignments</h3>

                <h2><?php echo $totalAssignments; ?></h2>

            </div>
            <div class="card">

    <h3>Attendance</h3>

    <h2><?php echo $attendancePercentage; ?>%</h2>
     <div class="progress-bar">

        <div class="progress"
             style="width: <?php echo $attendancePercentage; ?>%;">
        </div>

    </div>

</div>
            <div class="card">

    <h3>🏆 XP Points</h3>

    <h2><?php echo $xp; ?> XP</h2>

    <p>Level <?php echo $level; ?></p>

    <small><?php echo $badge; ?></small>

    <div class="xp-bar">

        <div class="xp-fill"
             style="width: <?php echo $xp % 100; ?>%;">

        </div>

    </div>

</div>

        </div>
        
    <div class="analytics-cards">

    <div class="analytics-card">
        <h3>Highest Marks</h3>
        <h2><?php echo $highestMarks; ?></h2>
        <p><?php echo $highestSubject; ?></p>
    </div>

    <div class="analytics-card">
        <h3>Average Marks</h3>
        <h2><?php echo $averageMarks; ?></h2>
    </div>

    <div class="analytics-card">
        <h3>Best Attendance</h3>
        <h2><?php echo $bestPercentage; ?>%</h2>
        <p><?php echo $bestSubject; ?></p>
    </div>

    <div class="analytics-card">
        <h3>Total Subjects</h3>
        <h2><?php echo $totalSubjects; ?></h2>
    </div>

</div>
        <!-- Student Information -->

<div class="student-info">

  <div class="info-header">

    <h2>Student Information</h2>

    <a href="edit_profile.php" class="edit-btn">
        <i class="fa-solid fa-user-pen"></i>
        Edit Profile
    </a>

</div>

    <table>
                <tr>
                    <td>Name</td>
                    <td><?php echo $studentName; ?></td>
                </tr>
                
                <tr>
                    <td>Roll Number</td>
                    <td><?php echo $student['rollno']; ?></td>
                </tr>

                <tr>
                    <td>Branch</td>
                    <td>AIML</td>
                </tr>

                <tr>
                    <td>Semester</td>
                    <td><?php echo $student['semester']; ?></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td><?php echo $student['email']; ?></td>
                </tr>

            </table>
         
        </div>
        

        <!-- Bottom Section -->

        <div class="bottom">

            <!-- Performance -->

              <div class="charts">
<div class="performance">
    <div class="schedule-header">

    <h2>Performance</h2>

    <a href="add_performance.php" class="add-class">

        <i class="fa-solid fa-plus"></i>

        Add Marks

    </a>

</div>
    <canvas id="barChart"></canvas>
</div>

<div class="attendance-chart">

    <div class="schedule-header">

    <h2>Attendance</h2>

    <a href="add_attendance.php" class="add-class">

        <i class="fa-solid fa-plus"></i>

        Add Attendance

    </a>

</div>
    <canvas id="attendanceChart"></canvas>
</div> 

    </div>
            <!-- Right Panel -->

            <div class="right-panel">

                <!-- Login Streak -->

                <div class="streak" id="streak">

                    <h2>⭐ Login Streak</h2>

                    <h1><?php echo $streak; ?> Days</h1>

                    <p>Current Reward Progress</p>

                   <div class="stars">
<?php

for($i=1;$i<=$streak;$i++)
{
    echo "⭐";
}

?>
</div>

                </div>

                <!-- Rewards -->

             <div class="reward" id="rewards">

    <h2>🏆 Rewards</h2>

    <h3>Level <?php echo $level; ?></h3>

<p><?php echo $badge; ?></p>

<progress value="<?php echo $xp; ?>" max="100"></progress>

<p><?php echo $xp; ?>/100 XP</p>

<?php
$remainingXP = 100 - $xp;
?>

<p><?php echo $remainingXP; ?> XP to next level</p>

</div>
            </div>

        </div>

        <!-- Timetable -->

       <div class="schedule" id="schedule">

           <div class="schedule-header">

<h2>Weekly Schedule</h2>

<a href="add_schedule.php" class="add-class">

<i class="fa-solid fa-plus"></i>

Add Class

</a>

</div>

            <table>

                <tr>
    <th>Day</th>
    <th>Subject</th>
    <th>Time</th>
    <th>Room</th>
    <th>Action</th>
</tr>

                <?php

$sql = "SELECT * FROM schedule
        WHERE student_id = ?
        ORDER BY FIELD(day,
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'),
        start_time";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

    <td><?php echo $row['day']; ?></td>

    <td><?php echo $row['subject']; ?></td>

    <td>
        <?php
        echo date("g:i A", strtotime($row['start_time'])) .
        " - " .
        date("g:i A", strtotime($row['end_time']));
        ?>
    </td>

    <td><?php echo $row['room']; ?></td>

    <td>

        <a href="edit_schedule.php?id=<?php echo $row['id']; ?>" class="edit-btn">
            <i class="fa-solid fa-pen"></i>
        </a>

        <a href="delete_schedule.php?id=<?php echo $row['id']; ?>"
           class="delete-btn"
           onclick="return confirm('Are you sure you want to delete this class?');">

            <i class="fa-solid fa-trash"></i>

        </a>

    </td>

</tr>

<?php
}
?>

            </table>

        </div>
        <div class="schedule-header">

</div>

        <!-- Homework -->

        <div class="homework" id="homework">

<div class="schedule-header">

<h2>Homework Reminder</h2>

<a href="add_homework.php" class="add-class">

<i class="fa-solid fa-plus"></i>

Add Homework

</a>

</div>

<ul>

<?php

$sql = "SELECT * FROM homework
        WHERE student_id=?
        ORDER BY due_date ASC";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result))
{

?>

<li>

<?php echo ($row['status']=="Completed") ? "✅" : "⬜"; ?>

<strong><?php echo htmlspecialchars($row['subject']); ?></strong>

-

<?php echo htmlspecialchars($row['title']); ?>

(<?php echo $row['due_date']; ?>)
<a href="edit_homework.php?id=<?php echo $row['id']; ?>" class="edit-btn">
    Edit
</a>

<a href="delete_homework.php?id=<?php echo $row['id']; ?>"
   class="delete-btn"
   onclick="return confirm('Delete Homework?');">
    Delete
</a>



</li>

<?php
}
?>

</ul>

</div>

        <!-- Exams -->

      <div class="exams" id="exams">

<div class="schedule-header">

<h2>Upcoming Exams</h2>

<a href="add_exam.php" class="add-class">

<i class="fa-solid fa-plus"></i>

Add Exam

</a>

</div>

<ul>

<?php

$sql = "SELECT *
        FROM exams
        WHERE student_id=?
        AND exam_date >= CURDATE()
        ORDER BY exam_date ASC";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

while($row=mysqli_fetch_assoc($result))
{
?>

<li>

<strong><?php echo htmlspecialchars($row['subject']); ?></strong>

-

<?php echo htmlspecialchars($row['exam_name']); ?>

<br>

📅 <?php echo $row['exam_date']; ?>

🕒 <?php echo date("g:i A",strtotime($row['exam_time'])); ?>

📍 <?php echo htmlspecialchars($row['room']); ?>

<a href="edit_exam.php?id=<?php echo $row['id']; ?>" class="edit-btn">

<i class="fa-solid fa-pen"></i>

</a>

<a href="delete_exam.php?id=<?php echo $row['id']; ?>"
class="delete-btn"
onclick="return confirm('Delete this exam?');">

<i class="fa-solid fa-trash"></i>

</a>

</li>

<?php
}
?>

</ul>

</div>
<div class="past-exams">

<div class="schedule-header">

<h2>Exam History</h2>

</div>

<ul>

<?php

$sql = "SELECT *
        FROM exams
        WHERE student_id=?
        AND exam_date < CURDATE()
        ORDER BY exam_date DESC";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result))
{
?>

<li class="past-exam">

<strong><?php echo htmlspecialchars($row['subject']); ?></strong>

-

<?php echo htmlspecialchars($row['exam_name']); ?>

<br>

📅 <?php echo $row['exam_date']; ?>

🕒 <?php echo date("g:i A",strtotime($row['exam_time'])); ?>

📍 <?php echo htmlspecialchars($row['room']); ?>

<span class="completed-badge">
Completed
</span>

<a href="delete_exam.php?id=<?php echo $row['id']; ?>"
class="delete-btn"
onclick="return confirm('Delete this exam?');">

<i class="fa-solid fa-trash"></i>

</a>

</li>

<?php
}
?>

</ul>

</div>

<!-- Chart.js -->
 <?php

$subjects = [];
$marks = [];

$sql = "SELECT subject, marks
        FROM performance
        WHERE student_id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while($row = mysqli_fetch_assoc($result))
{
    $subjects[] = $row['subject'];
    $marks[] = $row['marks'];
}

?>
<?php

$attendanceSubjects = [];
$attendancePercentages = [];

$sql = "SELECT subject,total_classes,attended_classes
FROM attendance
WHERE student_id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

while($row=mysqli_fetch_assoc($result))
{

    $attendanceSubjects[] = $row['subject'];

    if($row['total_classes']>0)
    {
        $attendancePercentages[] =
        round(($row['attended_classes']/$row['total_classes'])*100,2);
    }
    else
    {
        $attendancePercentages[] = 0;
    }

}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const subjects = <?php echo json_encode($subjects); ?>;

const marks = <?php echo json_encode($marks); ?>;
const attendanceSubjects =
<?php echo json_encode($attendanceSubjects); ?>;

const attendancePercentages =
<?php echo json_encode($attendancePercentages); ?>;


</script>
 
<script src="dashboard.js"></script>

</body>

</html>