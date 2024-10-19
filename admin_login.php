<?php
// admin_login.php
session_start();

// Database connection
$servername = "localhost"; // Update this to your database server
$username = "root"; // Update this to your database username
$password = ""; // Update this to your database password
$dbname = "bookstore"; // Update this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the submitted username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Prepare and execute the SQL statement to check if the admin exists
$sql = "SELECT * FROM Admins WHERE Username = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    
    // Verify the password (assuming you have hashed passwords)
    if (password_verify($password, $admin['Password'])) {
        // Set session variables and redirect to the admin dashboard
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin.php"); // Update this to your admin dashboard page
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No such user found.";
}

$stmt->close();
$conn->close();
?>
