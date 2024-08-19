<?php
require('connection.php');
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Ensure the database connection is established
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    
    // Fetch and sanitize form input
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $line = mysqli_real_escape_string($con, $_POST["line"]);
    $message = mysqli_real_escape_string($con, $_POST["message"]);
    $effect = mysqli_real_escape_string($con, $_POST["effect"]);
    
    // Check if the user is logged in
    if (!isset($_SESSION["username"])) {
        die("User is not logged in.");
    }

    // Create the update query
    $sql = "UPDATE data SET line='$line', message='$message', effect='$effect' WHERE id='$id' AND owner='" . $_SESSION["username"] . "'";

    // Execute the update query
    if (mysqli_query($con, $sql)) {
        // Redirect after successful update
         echo "<script>alert(' Updated Sucessfully'); window.location.href='add.php';</script>";

        exit();
    } else {
        // Display error message if the update fails
  echo "<script>alert(' Couldn't Update'); window.location.href='add.php';</script>" . mysqli_error($con);
    }
}

// Check if an ID is passed for editing
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $sql = "SELECT * FROM data WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "No record found!";
        exit();
    }
} else {
    echo "No ID provided!";
    exit();
}
$login = ' <li class="nav-item">
            <a class="nav-link" href="./index.php">Login</a>
          </li>';
$logout = ' <li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>';
$settings = '<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Setting
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#">Static IP</a></li>
              <li><a class="dropdown-item" href="./usersetting.php">User Setting</a></li>';
$register = '<li><a class="dropdown-item" href="./newuser.php">Register User</a></li>';    
$view = ' <li class="nav-item">
            <a class="nav-link" href="./dataview.php">View</a>
          </li>';
$home = ' <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./add.php">Add Page</a>
          </li>';  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="./editdata.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Edit Record</h2>
        <form method="post" action="./editdata.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <div class="mb-3">
                <label for="line" class="form-label">Line:</label>
                <input type="text" name="line" id="line" value="<?php echo htmlspecialchars($row['line']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <input type="text" name="message" id="message" value="<?php echo htmlspecialchars($row['message']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="effect" class="form-label">Effect:</label>
                <select name="effect" id="effect" class="form-select" required>
                    <option value="0" <?php if ($row['effect'] == '0') echo 'selected'; ?>>Blink</option>
                    <option value="1" <?php if ($row['effect'] == '1') echo 'selected'; ?>>Scroll</option>
                    <option value="2" <?php if ($row['effect'] == '2') echo 'selected'; ?>>Blink & Scroll</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($con);
?>
