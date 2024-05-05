<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $city = $_POST["city"];
    // $device = $_POST["Device"];

    
    // if ($device === "Device") {
    //     $device = 'none';
    // }

    // Perform database insertion
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "hisenseEurope";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Construct SQL query
    $sql = "INSERT INTO form (name, email, city, mobile) 
            VALUES ('$name', '$email', '$city', '$mobile')";

    // Execute SQL statement
    try {
        mysqli_query($conn, $sql);
        $targetDir = __DIR__ . "/invoices/";
        $targetFile = $targetDir . basename($email . "*" . $_FILES['invoice']["name"]);

        if (move_uploaded_file($_FILES['invoice']['tmp_name'], $targetFile)) {
            echo "The file ". htmlspecialchars(basename($_FILES['invoice']["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        mysqli_close($conn);
        // // Redirect to the same page or show a success message
        if($_POST['lang'] == 'en'){
            header("Location: "."thank-you.html");
            exit();
        }
        else{
            header("Location: "."thank-you-ar.html");
            exit();
        }
        header("Location: "."thank-you.html");
        exit();

    } catch (\Throwable $th) {
        if (mysqli_errno($conn) == 1062) {
            header("Location: index-en.html?error=email_exists");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    
}
?>
