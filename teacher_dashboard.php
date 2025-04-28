<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])|| $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit();
}
$name = ($_SESSION['name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            background-image: linear-gradient(rgba(4,9,30,0.7),rgba(4,9,30,0.7)), url(university.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            color: white;

        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
            position: fixed;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>Teacher Panel</h3>
    <a href="teacher_dashboard.php">Dashboard</a>
    <a href="manage_student.php">Manage Students</a>
    <a href="attendance.php">Manage Attendance</a>
    <a href="fileupload.php">Upload Materials</a>
    <a href="view_course.php">courses</a>
    <a href="logout.php" class="btn btn-danger w-100">Logout</a>
</div>

<div class="content">
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Welcome, <?php echo $name; ?>!</span>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Teacher Dashboard</h2>
        <p>Manage students, attendance, and course materials.</p>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Manage Students</h5>
                        <p class="card-text">Add, edit, or remove student records.</p>
                        <a href="manage_student.php" class="btn btn-light">Go to Students</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Take Attendance</h5>
                        <p class="card-text">Track and update student attendance.</p>
                        <a href="takeAttendance.php" class="btn btn-light">Go to Attendance</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Manage Attendance</h5>
                        <p class="card-text">Track and update student attendance.</p>
                        <a href="attendance.php" class="btn btn-light">Go to Attendance</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Upload Materials</h5>
                        <p class="card-text">Share course files and study materials.</p>
                        <a href="fileupload.php" class="btn btn-light">Upload Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Enroll</h5>
                        <p class="card-text">Enrolled courses.</p>
                        <a href="view_course.php" class="btn btn-light">View course</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
