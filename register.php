<?php
// Start the session
session_start();

// Include the database connection file
require('connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $usertype = $_POST['usertype'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
        echo "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif ($password !== $confirmpassword) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
     //   $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $sql = "INSERT INTO users (username, email, password, usertype) VALUES (?, ?, ?, ?)";

        // Initialize and execute the statement
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("sssi", $username, $email, $password, $usertype);

            if ($stmt->execute()) {
                 echo "<script>alert(' Successfully regitered'); window.location.href='usersetting.php';</script>";
            
            } else {
             echo "<script>alert(' Registration Unsucessful'); window.location.href='newuser.php';</script>" . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error: " . $con->error;
        }
    }

    // Close the database connection
    $con->close();
}
?>
