<?php 

require("connection.php");
session_start();

$login = '<li class="nav-item">
            <a class="nav-link" href="./index.php">Login</a>
          </li>';
$logout = '<li class="nav-item">
            <a class="nav-link" href="./logout.php">Logout</a>
          </li>';
$settings = '<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Settings
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#">Static IP</a></li>
              <li><a class="dropdown-item" href="./usersetting.php">User Setting</a></li>';
$register = '<li><a class="dropdown-item" href="./newuser.php">Register User</a></li>';    
$view = '<li class="nav-item">
            <a class="nav-link" href="./dataview.php">View</a>
          </li>';
$home = '<li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./add.php">Add Page</a>
          </li>';         
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* General styles */
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        /* Form container */
        .d1 {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 400px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Form elements */
        .d1 p {
            margin: 0 0 10px;
            font-weight: bold;
        }

        .d1 input[type="text"],
        .d1 input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .d1 input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .d1 input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .d1 {
                padding: 15px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://www.magdyn.com/Products-Services/">Magneto Dynamics</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               
              
            </div>
        </div>
    </nav><br><br>

    <div class="d1">
        <fieldset>
      <center>      <h1>Login</h1>  </center>
            <form action="./login.php" method="post">
                <p>Username</p>
                <input id="username" name="username" type="text">
                <p>Password</p>
                <input id="password" name="password" type="password">
                <input type="submit" id="btn" name="submit" value="Login">
            </form>
        </fieldset>
    </div>

    <script src="./log.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
