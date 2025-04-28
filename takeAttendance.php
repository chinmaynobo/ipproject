<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$validStatuses = ['P', 'A', 'L', 'H'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto shadow-lg p-4" style="max-width: 700px;">
        <h2 class="text-center">Take Attendance</h2>
        <form action="" method="POST">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Student Name</th>
                        <th>P</th>
                        <th>A</th>
                        <th>L</th>
                        <th>H</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $stmt = mysqli_prepare($conn, "SELECT id, name FROM users WHERE role = 0");
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($data = mysqli_fetch_assoc($result)) {
                            $student_name = $data["name"];
                            $student_id = $data["id"];
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student_name); ?></td>
                        <td><input type="radio" name="attendance[<?php echo $student_id; ?>]" value="P" required></td>
                        <td><input type="radio" name="attendance[<?php echo $student_id; ?>]" value="A"></td>
                        <td><input type="radio" name="attendance[<?php echo $student_id; ?>]" value="L"></td>
                        <td><input type="radio" name="attendance[<?php echo $student_id; ?>]" value="H"></td>
                    </tr>
                    <?php } 
                        mysqli_stmt_close($stmt);
                    ?>
                    <tr>
                        <td>Select Date</td>
                        <td colspan="4"><input type="date" class="form-control" name="selectedDate" required></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <button type="submit" name="submitButton" class="btn btn-primary w-100">Submit Attendance</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <a href="teacher_dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a>
    </div>
</div>

<?php 
if (isset($_POST['submitButton'])) {
    try {
        date_default_timezone_set("Asia/Dhaka");
        $selected_date = $_POST['selectedDate'] ?? date("Y-m-d");
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $selected_date)) {
            throw new Exception("Invalid date format");
        }
        $attendance_month = date("M", strtotime($selected_date));
        $attendance_year = date("Y", strtotime($selected_date));

        if (isset($_POST['attendance'])) {
            foreach ($_POST['attendance'] as $student_id => $attendance) {
                if (!in_array($attendance, $validStatuses)) {
                    throw new Exception("Invalid attendance status for student ID $student_id");
                }
                $query = "INSERT INTO attendance (student_id, attendance_date, attendance_month, attendance_year, attendance) 
                          VALUES (?, ?, ?, ?, ?) 
                          ON DUPLICATE KEY UPDATE attendance = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "isssis", $student_id, $selected_date, $attendance_month, $attendance_year, $attendance, $attendance);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
            echo "<div class='alert alert-success text-center'>Attendance Added Successfully</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}
?>
</body>
</html>