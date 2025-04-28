<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";
$upload_dir = "uploads/";

// Ensure the uploads directory exists and is writable
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0755, true)) {
        $message = "<div class='alert alert-danger text-center'>Failed to create uploads directory.</div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES['pdf_file']['name'])) {
    // Validate file type and size (e.g., max 5MB)
    $allowed_types = ['application/pdf'];
    $max_size = 5 * 1024 * 1024; // 5MB
    $file_type = $_FILES['pdf_file']['type'];
    $file_size = $_FILES['pdf_file']['size'];

    if (!in_array($file_type, $allowed_types)) {
        $message = "<div class='alert alert-danger text-center'>Only PDF files are allowed.</div>";
    } elseif ($file_size > $max_size) {
        $message = "<div class='alert alert-danger text-center'>File size exceeds 5MB limit.</div>";
    } else {
        // Sanitize file name
        $file_name = preg_replace("/[^A-Za-z0-9._-]/", "", basename($_FILES['pdf_file']['name']));
        $file_path = $upload_dir . $file_name;
        $uploaded_by = $_SESSION['user_id'];

        // Check if directory is writable
        if (!is_writable($upload_dir)) {
            $message = "<div class='alert alert-danger text-center'>Uploads directory is not writable.</div>";
        } elseif (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $file_path)) {
            // Use prepared statement to prevent SQL injection
            $query = "INSERT INTO pdf_files (file_name, file_path, uploaded_by) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $file_name, $file_path, $uploaded_by);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success text-center'>Upload successful!</div>";
            } else {
                $message = "<div class='alert alert-danger text-center'>Database insert failed.</div>";
                // Delete the uploaded file if database insert fails
                unlink($file_path);
            }
            $stmt->close();
        } else {
            $message = "<div class='alert alert-danger text-center'>File upload failed.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto shadow-lg p-4" style="max-width: 500px;">
        <h2 class="text-center">Upload PDF File</h2>

        <?php if (!empty($message)) echo $message; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="pdf_file" class="form-label">Select PDF</label>
                <input type="file" class="form-control" name="pdf_file" accept=".pdf" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </form>

        <a href="teacher_dashboard.php" class="btn btn-secondary w-100 mt-3">Back to Dashboard</a>
    </div>
</div>

</body>
</html>