<?php
// Include the database connection file
require('connection.php');
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

// Fetch all records from the 'data' table  
$sql = "SELECT * FROM data";
$result = mysqli_query($con, $sql);

$login = '<li class="nav-item">
            <a class="nav-link" href="./index.php">Login</a>
          </li>';
$logout = '<li class="nav-item">
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
$view = '<li class="nav-item">
            <a class="nav-link" href="./dataview.php">View</a>
          </li>';
$home = '<li class="nav-item">
            <a class="nav-link active" aria-current="page" href="./add.php">Add page</a>
          </li>';          
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>
   
  <style>
        body {
            background-color: #f8f9fa;
        }

        .container, .navbar, .form-group, .data-table-container, fieldset {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #ffffff;
            margin-bottom: 20px;
            max-width: 1200px; /* Limit container width */
            margin-left: auto;
            margin-right: auto;
        }

        .horizontal-form {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .horizontal-form .form-group {
            flex: 1;
            min-width: 150px;
        }

        .horizontal-form .form-submit {
            flex: 0;
            margin-left: auto;
        }

        .form-group input, .form-group select {
            max-width: 200px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .horizontal-form {
                flex-direction: column;
                align-items: center;
            }

            .horizontal-form .form-group, .horizontal-form .form-submit {
                width: 100%;
                text-align: center;
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
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://www.magdyn.com/">Magneto Dynamics</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
           
                <form action="./logout.php" class="d-flex">
                    <input class="form-control me-2" type="search" readOnly placeholder="<?php echo $_SESSION["username"]; ?>" aria-label="Search">
                    <button class="btn btn-outline-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>

<div class="container mt-5">
    <h2 class="mb-4">Data Table</h2>
    <table id="dataTable"  style="width:100%">
        <thead>
            <tr>
                <th>Id</th>
                <th>Line</th>
                <th>Message</th>
                <th>Type</th>
                <th>Created By</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $id = $row["id"];
                    $line = $row["line"];
                    $message = $row["message"];
                    $effect = $row["effect"];
                    $owner = $row["owner"];
                    
                    // Convert the effect integer to a string
                    switch ($effect) {
                        case 0:
                            $effect = "Blink";
                            break;
                        case 1:
                            $effect = "Scroll";
                            break;
                        case 2:
                            $effect = "Blink & Scroll";
                            break;
                        default:
                            $effect = "Unknown";
                    }

                    // Output the data
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $line . "</td>";
                    echo "<td>" . $message . "</td>";
                    echo "<td>" . $effect . "</td>";
                    $owner_sql = "SELECT username FROM users WHERE id='$owner'";
                    $owner_result = mysqli_query($con, $owner_sql);
                    $owner_row = mysqli_fetch_assoc($owner_result);
                    $owner_name = $owner_row ? $owner_row["username"] : "Unknown";
                    echo "<td>" . $owner_name . "</td>";
                    if($_SESSION["usertype"] == 2 || $_SESSION["usertype"] == 0){
                        echo "<td><a href='./editdata.php?id=" . $id . "' class='btn btn-primary'>Edit</a></td>";
                        echo "<td><a href='./removedata.php?id=" . $id . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Remove</a></td>";
                    }
                    else{
                        echo '<td></td>
        <td></td>';
                    }
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
        
    </table>
</div>

<script>
    $(document).ready(function() {
        // $('#dataTable').DataTable();
        let table = new DataTable('#dataTable');
    //     const form = document.querySelector("form");
    // const lineInput = document.getElementById("line");
    // const messageInput = document.getElementById("message");
    // const effectSelect = document.getElementById("effect");

    // form.addEventListener("submit", function (event) {
    //     let isValid = true;

    //     // Validate Line Input
    //     const lineValue = parseInt(lineInput.value);
    //     if (isNaN(lineValue) || lineValue < 1 || lineValue > 3) {
    //         alert("Line number must be between 1 and 3.");
    //         lineInput.focus();
    //         isValid = false;
    //     }

    //     // Validate Message Input
    //     const messageValue = messageInput.value.trim();
    //     if (messageValue === "") {
    //         alert("Message cannot be empty.");
    //         messageInput.focus();
    //         isValid = false;
    //     } else if (messageValue.length > 100) {
    //         alert("Message cannot exceed 100 characters.");
    //         messageInput.focus();
    //         isValid = false;
    //     }

    //     // Validate Effect Selection
    //     const effectValue = effectSelect.value;
    //     if (effectValue === "") {
    //         alert("Please select an effect.");
    //         effectSelect.focus();
    //         isValid = false;
    //     }

    //     // If any validation fails, prevent the form from submitting
    //     if (!isValid) {
    //         event.preventDefault();
    //     }
    // });
    });
</script>
    <!-- <script src="add.js"></script> -->

</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>