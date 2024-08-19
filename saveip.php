<?php
// Starting output buffering at the top of your script
ob_start();

require('connection.php');

// Your form handling logic here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_address = $_POST['ip'];

    if (filter_var($ip_address, FILTER_VALIDATE_IP)) {
        // Attempt to save the IP address to the database
        $stmt = $con->prepare("INSERT INTO staticip (ip) VALUES (?)");

        if ($stmt) {
            $stmt->bind_param("s", $ip_address);

            if ($stmt->execute()) {
                // Successful insertion
                echo "<script>alert('IP saved successfully');</script>";
                header("Location:add.php");
            } else {
                // Error during execution
                echo "<script>alert('Error saving IP: " . htmlspecialchars($stmt->error) . "');</script>";
            }

            $stmt->close();
        } else {
            // Prepare statement failed
            echo "<script>alert('Prepare failed: " . htmlspecialchars($con->error) . "');</script>";
        }
    } else {
        // Invalid IP format
        echo "<script>alert('Invalid IP address format');</script>";
    }
}

// Close the database connection
$con->close();

// Flush the output buffer and send the output
ob_end_flush();
?>
