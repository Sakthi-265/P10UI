<?php
require("connection.php");
session_start();

// Redirect based on session
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit();
} elseif ($_SESSION["usertype"] == 1) {
    header("Location:dataview.php");
    exit();
}

// Fetch data from the database
$sql = "SELECT * FROM data";
$result = mysqli_query($con, $sql);

// Navigation items based on user type
$ip = '
    <form action="./saveip.php" method="post">
        <label for="ip_address">Static IP Address:</label>
        <input type="text" id="ip_address" name="ip" required>
        <input type="submit" value="Save IP Address">
    </form>
';
$login = '<li class="nav-item"><a class="nav-link" href="./index.php">Login</a></li>';
$logout = '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';
$settings = '
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Settings
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="./usersetting.php">User Settings</a></li>
            <li><a class="dropdown-item" href="./newuser.php">Register User</a></li>
        </ul>
    </li>
';
$register = '<li><a class="dropdown-item" href="./newuser.php">Register User</a></li>';
$view = '<li class="nav-item"><a class="nav-link" href="./dataview.php">View</a></li>';
$home = '<li class="nav-item"><a class="nav-link active" aria-current="page" href="./add.php">Home</a></li>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./add.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            margin-bottom: 20px;
        }

        .container, .navbar, .form-group, .data-table-container, fieldset {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #ffffff;
            margin-bottom: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Align form like a navbar */
        .form-inline {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            justify-content: space-between;
        }

        .form-inline .form-group {
            flex: 1;
            min-width: 150px;
        }

        .form-inline input, .form-inline select {
            width: 100%;
            max-width: 250px;
            margin-bottom: 0;
        }

        .form-inline .form-submit {
            margin-left: auto;
            padding-left: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-inline {
                flex-direction: column;
                align-items: stretch;
            }

            .form-inline .form-group {
                width: 100%;
            }

            .form-inline .form-submit {
                width: 100%;
                text-align: center;
                margin-left: 0;
            }
        }

        /* DataTable scroll styles */
        .data-table-container {
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
            text-align: center;
        }

        table.dataTable {
            width: 100% !important;
        }
    </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://www.magdyn.com/">Magneto Dynamics</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <?php echo $home; ?>
                    <?php if ($_SESSION["usertype"] == 0) { echo $settings; } ?>
                </ul>
                <form action="./logout.php" class="d-flex">
                    <input class="form-control me-2" type="search" readOnly placeholder="<?php echo $_SESSION["username"]; ?>" aria-label="Search">
                    <button class="btn btn-outline-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
      <fieldset>
        <form action="./register.php" method="post" class="form-inline">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input id="confirmpassword" name="confirmpassword" type="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="usertype">User Type</label>
                <select name="usertype" id="usertype" class="form-control">
                    <option value="0">Admin</option>
                    <option value="1">User</option>
                  
                </select>
            </div>
            <div class="form-submit">
                <input type="submit" id="btn" name="submit" value="Register" class="btn btn-primary">
            </div>
        </form>
      </fieldset>
    </div>

     <script src="./register.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
