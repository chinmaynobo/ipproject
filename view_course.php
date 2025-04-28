<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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



<div class="container mt-5">
    <div class="card p-4 shadow-lg" style="max-width: 1000px; margin: 0 auto;">
        <h2 class="text-center mb-4">My Registered Courses</h2>

        <?php if (empty($registered_courses)): ?>
            <div class="alert alert-warning text-center">You have not registered for any courses yet.</div>
        <?php else: ?>
            <div class="table-responsive">
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
                            <?php if ($course): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($course['code']); ?></td>
                                    <td><?php echo htmlspecialchars($course['name']); ?></td>
                                    <td><?php echo htmlspecialchars($course['credits']); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="teacher_dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>