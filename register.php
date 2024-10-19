<?php
// Include the database configuration file
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id FROM Users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        
        // Execute the statement
        $stmt->execute();
        $stmt->store_result();

        // Check if username or email already exists
        if ($stmt->num_rows > 0) {
            echo "<script>alert('Username or email already exists.');</script>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare statement to insert the new user
            $stmt = $conn->prepare("INSERT INTO Users (username, password, email, role) VALUES (?, ?, ?, 'user')");
            $stmt->bind_param("sss", $username, $hashed_password, $email);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! You can now sign in.');</script>";
            } else {
                echo "<script>alert('Error in registration. Please try again.');</script>";
            }
        }
        
        // Close statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Online Bookstore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        /* Custom styles for the register page */
        body {
            background-color: #f8f8f8; /* Light background color */
        }
        .navbar {
            margin-bottom: 20px;
        }
        .content {
            padding: 20px;
            max-width: 600px; /* Limit content width */
            margin: 0 auto; /* Center the content */
            background-color: #fff; /* White background for content area */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        h1 {
            margin-bottom: 20px;
            color: #333; /* Dark text color */
            text-align: center; /* Center the heading */
        }
        .form-group {
            margin-bottom: 15px; /* Space between form fields */
        }
    </style>
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
            <li><a href="books.html" style="font-size: 18px; font-weight: bold;">Books</a></li>
            <li><a href="signin.php" style="font-size: 18px; font-weight: bold;">Sign In</a></li>
        </ul>
    </div>
</nav>

<!-- Registration Content -->
<div class="container content">
    <h1>Create an Account</h1>
    <p>Please fill in the details below to create a new account.</p>
    
    <form action="register.php" method="post"> <!-- Updated action to submit to the same page -->
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    
    <a href="index.php" class="btn btn-primary" style="margin-top: 20px; text-align: center; ">Back to Home</a>
</div>

</body>
</html>
