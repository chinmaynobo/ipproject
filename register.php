<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-lg p-4 rounded" style="width: 400px;">
        <div class="text-center mb-3">
            <img src="logo1.png" alt="Logo" class="img-fluid" style="width: 120px;">
        </div>

        <h2 class="text-center">Register</h2>

        <?php 
        if(isset($_POST["submit"])) {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $contact = $_POST["contact"];
            $location = $_POST["location"];
            $password = $_POST["password"];

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, contact, location, password) 
                    VALUES ('$name', '$email', '$contact', '$location', '$hashed_password')";

            if(mysqli_query($conn, $sql)){
                echo '<div class="alert alert-success">Registration successful!</div>';
            } else {
                echo '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
            }

            mysqli_close($conn);
        }
        ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact</label>
                <input type="text" class="form-control" name="contact" placeholder="Enter Contact" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" class="form-control" name="location" placeholder="Enter Location" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </div>

</body>
</html>
