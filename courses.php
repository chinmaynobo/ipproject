<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all courses from the database
$result = $conn->query("SELECT * FROM courses");
$courses = $result->fetch_all(MYSQLI_ASSOC);

// Fetch the student's registered courses from the database
$stmt = $conn->prepare("SELECT course_code FROM student_courses WHERE student_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$registered_courses = [];
while ($row = $result->fetch_assoc()) {
    $registered_courses[] = $row['course_code'];
}
$stmt->close();

// Handle course registration
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['course_code'])) {
    $course_code = $_POST['course_code'];
    if (!in_array($course_code, $registered_courses)) {
        $stmt = $conn->prepare("INSERT INTO student_courses (student_id, course_code) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['user_id'], $course_code);
        if ($stmt->execute()) {
            $registered_courses[] = $course_code;
            $message = "Successfully registered for course: $course_code";
        } else {
            $message = "Error registering for course: $course_code";
        }
        $stmt->close();
    } else {
        $message = "You are already registered for this course.";
    }
}

function getCourseByCode($courses, $code) {
    foreach ($courses as $course) {
        if ($course['code'] === $code) {
            return $course;
        }
    }
    return null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Course Manager</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <div class="card mx-auto shadow-lg p-4" style="max-width: 1000px;">
        <h2 class="text-center">Course Registration</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"> <?= htmlspecialchars($message) ?> </div>
        <?php endif; ?>

        <h4 class="mt-4">Some Available Courses</h4>
        <div class="mb-3">
            <label for="departmentFilter">Filter by Department:</label>
            <select id="departmentFilter" class="form-select w-25 d-inline-block">
                <option>All</option>
                <!-- Add more department options as needed -->
            </select>
        </div>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Instructor</th>
                    <th>Credits</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= htmlspecialchars($course['code']) ?></td>
                        <td><?= htmlspecialchars($course['name']) ?></td>
                        <td><?= htmlspecialchars($course['instructor']) ?></td>
                        <td><?= htmlspecialchars($course['credits']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="course_code" value="<?= htmlspecialchars($course['code']) ?>">
                                <button type="submit" class="btn" style="background-color: #0B5ED7; border-color: #0B5ED7; color: #ffffff;">Register</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="mt-4">My Registered Courses</h4>
        <table class="table table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credits</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registered_courses as $code): ?>
                    <?php $course = getCourseByCode($courses, $code); ?>
                    <tr>
                        <td><?= htmlspecialchars($course['code']) ?></td>
                        <td><?= htmlspecialchars($course['name']) ?></td>
                        <td><?= htmlspecialchars($course['credits']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="text-center mt-3">
    <a href="student_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>