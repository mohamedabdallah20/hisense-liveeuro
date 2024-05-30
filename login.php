<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password']; // Consider hashing passwords in production

// SQL to check the username and password
$ourUsername = "admin";
$ourPassword = "admin";


if ($username == $ourUsername && $password == $ourPassword) {
    $_SESSION['loggedin'] = true;
    header("Location: users.php"); // Redirect to the user list page
} else {
    echo "Invalid username or password";
    header("Location: index-en.html"); // Redirect to the user list page

}
$conn->close();
?>
