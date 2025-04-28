<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT name, email FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id='$user_id'";
    } else {
        $query = "UPDATE users SET name='$name', email='$email' WHERE id='$user_id'";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['name'] = $name;
        echo "<script>alert('Profile updated successfully!'); window.location='editprofile.php';</script>";
    } else {
        echo "<script>alert('Update failed!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Profile Manager</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="text-center">Edit Profile</h3>
    <form method="POST" class="w-50 mx-auto">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" class="form-control" required><br>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" class="form-control" required><br>

        <label>New Password (optional)</label>
        <input type="password" name="password" class="form-control"><br>

        <button type="submit" name="update" class="btn btn-primary w-100">Update</button>
    </form>

    <div class="text-center mt-3">
        <a href="student_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>
</body>
</html>
