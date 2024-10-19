<?php
// Include the database configuration file
include 'config.php';

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT password, role FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();
    
    // Check if username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Successful login
            $_SESSION['username'] = $username; // Set session variable
            $_SESSION['role'] = $role; // Store user role if needed
            header("Location: index.php"); // Redirect to index page
            exit(); // Ensure no further code is executed
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('Username not found.');</script>";
    }

    // Close statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign In - Online Bookstore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css"> <!-- Link to the updated stylesheet -->
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php" style="font-size: 18px; font-weight: bold;">Book Heaven</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="aboutus.html" style="font-size: 18px; font-weight: bold;">About Us</a></li>
            <li><a href="contactus.html" style="font-size: 18px; font-weight: bold;">Contact Us</a></li>
            <li><a href="register.php" style="font-size: 18px; font-weight: bold;">Register</a></li>
            <li class="active" style="font-size: 18px; font-weight: bold;"><a href="signin.php">Sign In</a></li>
        </ul>
    </div>
</nav>

<!-- Sign In Content -->
<div class="container content">
    <h1>Sign In</h1>
    <p>Please enter your credentials to log in.</p>
    
    <form action="signin.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign In</button>
    </form>
    
    <a href="index.php" class="btn btn-default" style="margin-top: 20px;">Back to Home</a>
</div>

</body>
</html>
