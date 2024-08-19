<?php
// Include the database connection file
require('connection.php');

// Start session and check if user is logged in and is an admin
session_start();
if (!isset($_SESSION['username']) || $_SESSION["usertype"] != 0) {
    header("Location:index.php");
    exit;
}

// Check if ID is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location:usersetting.php");
    exit;
}

$id = $_GET['id'];

// Fetch user details from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows != 1) {
    header("Location:usersetting.php");
    exit;
}

$user = $result->fetch_assoc();

// Assign fetched data to variables
$username = $user['username'];
$email = $user['email'];
$usertype = $user['usertype'];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];

    // Validate form data
    if (empty($username) || empty($email) || !isset($usertype)) {
        echo "All fields are required.";
    } else {
        // Update user in the database
        $sql = "UPDATE users SET username = ?, email = ?, usertype = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssii', $username, $email, $usertype, $id);

        if ($stmt->execute()) {
            echo "<script>alert(' Previlleges updated successfully'); window.location.href='usersetting.php';</script>";

            exit;
        } else {
    echo "<script>alert(' Couldn't update '); window.location.href='usersetting.php';</script>". $con->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with ID</title>
    <link rel="stylesheet" href="./register.css">
</head>
<body>
    <form action="./edituser.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        
        <p>Username</p>
        <input name="username" type="text" value="<?php echo htmlspecialchars($username); ?>" required>
        
        <p>Email</p>
        <input name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" required>
        
        <p>User Type</p>
        <select name="usertype" required>
            <option value="0" <?php echo $usertype == 0 ? 'selected' : ''; ?>>Admin</option>
            <option value="1" <?php echo $usertype == 2 ? 'selected' : ''; ?>>View User</option>
            <option value="2" <?php echo $usertype == 3 ? 'selected' : ''; ?>>Edit User</option>
        </select>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
