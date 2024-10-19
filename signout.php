<?php
session_start(); // Start the session

// Destroy all session data
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the logged-out page
header("Location: loggedout.php");
exit(); // Ensure no further code is executed
?>
