<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$selectedMonth = isset($_GET['selected_month']) ? $_GET['selected_month'] : date("Y-m");
if (!preg_match("/^\d{4}-\d{2}$/", $selectedMonth)) {
    $selectedMonth = date("Y-m"); // Fallback to current month if invalid
}
$firstDayOfMonth = $selectedMonth . "-01";
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

$stmt = mysqli_prepare($conn, "SELECT id, name FROM users WHERE role = 0");
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$students = [];
while ($row = mysqli_fetch_assoc($result)) {
    $students[] = $row;
}
mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow-lg">
        <h2 class="text-center mb-4">Student Attendance</h2>
        <form method="GET" class="mb-3 d-flex justify-content-center">
            <label for="month" class="me-2 fw-bold">Select Month:</label>
            <input type="month" id="month" name="selected_month" value="<?php echo htmlspecialchars($selectedMonth); ?>" class="form-control w-auto">
            <button type="submit" class="btn btn-primary ms-2">View Attendance</button>
        </form>
        <h4 class="text-center">Attendance of: <?php echo strtoupper(date("F Y", strtotime($firstDayOfMonth))); ?></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="2">Names</th>
                        <?php for ($j = 1; $j <= $totalDaysInMonth; $j++): ?>
                            <th><?php echo $j; ?></th>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <?php for ($j = 1; $j <= $totalDaysInMonth; $j++): ?>
                            <th><?php echo date("D", strtotime("$firstDayOfMonth +".($j-1)." days")); ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <?php 
                                for ($j = 1; $j <= $totalDaysInMonth; $j++): 
                                    $dateOfAttendance = $selectedMonth . "-" . str_pad($j, 2, "0", STR_PAD_LEFT);
                                    $query = "SELECT attendance FROM attendance WHERE student_id = ? AND attendance_date = ?";
                                    $stmt = mysqli_prepare($conn, $query);
                                    mysqli_stmt_bind_param($stmt, "is", $student['id'], $dateOfAttendance);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    $attendance = mysqli_fetch_assoc($result)['attendance'] ?? '';
                                    mysqli_stmt_close($stmt);
                            ?>
                                <td><?php echo htmlspecialchars($attendance); ?></td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="teacher_dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a>
    </div>
</div>
</body>
</html>