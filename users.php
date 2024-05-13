<?php
include 'db.php'; // Includes the database connection
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index-en.html"); // Redirect to login page
    exit;
}
function exportUsersToCSV($conn) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=users.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('Name', 'Email', 'City', 'Mobile'));  // Column headings

    $query = "SELECT name, email, city, mobile FROM form"; // Adjust the column names as per your database schema
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);  // Add rows to CSV
    }

    fclose($output);
    $conn->close();
    exit;
}
if (isset($_POST['export'])) {
    exportUsersToCSV($conn);
}

echo '<!DOCTYPE html><html lang="en"><head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<style>';
echo '.container { margin-top: 50px; }';
echo '.table { box-shadow: 0 5px 15px rgba(0,0,0,0.1); background-color: #ffffff; }';
echo '.table thead th { background-color: #343a40; color: #ffffff; }';
echo '.table tbody td { vertical-align: middle; border-top: solid 1px #dee2e6; }';
echo '.table-hover tbody tr:hover { background-color: #f8f9fa; }';
echo '</style>';
echo '</head><body>';
echo "<div class='container mt-4'>";

echo "<form method='post'>";
echo "<button type='submit' name='export' class='btn btn-success mb-3'>Export Users to CSV</button>";
echo "</form>";

$sql = "SELECT name, email, city, mobile FROM form"; // Adjust the column names as per your database schema
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-hover'>"; // Added 'table-hover' for hover effect
    echo "<thead class='thead-dark'>";
    echo "<tr><th>Name</th><th>Email</th><th>City</th><th>Mobile</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"]. "</td><td>" . $row["email"]. "</td><td>" . $row["city"]. "</td><td>" . $row["mobile"]. "</td></tr>";
    }
    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "<p class='text-center'>No results found.</p>";
}
echo '</body><style>.table thead th{background-color:#00a9a5 !important;color:#ffffff !important;}</style></html>';
$conn->close();
?>
