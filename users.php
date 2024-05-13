<?php
include 'db.php'; // Includes the database connection
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index-en.html"); // Redirect to login page
    exit;
}
$sql = "SELECT name, email,city,mobile,answer FROM form"; // Adjust the column names as per your database schema
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='container mt-4'>";
    echo "<table class='table'>";
    echo "<thead class='thead-dark'>";
    echo "<tr><th>name</th><th>email</th><th>city</th><th>mobile</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["city"]. "</td><td>" . $row["mobile"]. "</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "0 results";
}
$conn->close();
?>
