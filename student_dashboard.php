<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}
$name = ($_SESSION['name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
    <h3>Student Dashboard</h3>
    <a href="student_dashboard.php">Dashboard</a>
    <a href="view_attandance.php">Attendance</a>
    <a href="view_file.php">Courses Book</a>
    <a href="profile.php">Profile</a>
    <a href="courses.php">Courses</a>
    <a href="logout.php" class="btn btn-danger w-100">Logout</a>
</div>

<div class="content">
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Welcome, <?php echo $name; ?>!</span>
        </div>
    </nav>

<div class="container mt-4">
    <h2>Student Dashboard</h2>
    
    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Attendance</h5>
                    <p class="card-text">Check your monthly attendance records.</p>
                    <a href="view_attandance.php" class="btn btn-light">View Attendance</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Courses Book</h5>
                    <p class="card-text">View your enrolled courses books.</p>
                    <a href="view_file.php" class="btn btn-light">View Courses</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">Update your profile details.</p>
                    <a href="editprofile.php" class="btn btn-light">Edit Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Courses</h5>
                    <p class="card-text">View your enrolled courses.</p>
                    <a href="courses.php" class="btn btn-light">View Courses</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
