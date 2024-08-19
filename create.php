<?php
// Include the database connection file
require('connection.php');
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve and sanitize the form data
    $line = mysqli_real_escape_string($con, $_POST["line"]);
    $message = mysqli_real_escape_string($con, $_POST["message"]);
    $type = mysqli_real_escape_string($con, $_POST["effect"]);
    $owner = $_SESSION["user_id"];

    // Prepare the SQL query with proper column names
    $sql = "INSERT INTO data (line, message, effect, owner) VALUES ('$line', '$message', '$type', '$owner')";

    // Execute the query and check for success
    if (mysqli_query($con, $sql)) {
        // Output JavaScript alert for success
        echo "<script>alert('New record created successfully'); window.location.href='add.php';</script>";
    } else {
        // Output JavaScript alert for error
        echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href='add.php';</script>";
    }
}

// Close the database connection
mysqli_close($con);
?>
