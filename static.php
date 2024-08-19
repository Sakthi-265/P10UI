<?php
require("connection.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Static IP</title>
    <link rel="stylesheet" href="./static.css">
</head>
<body>
    <form action="./saveip.php" method="post">
        <label for="ip_address">Static IP Address:</label>
        <input type="text" id="ip_address" name="ip" required>
        <input type="submit" value="Save IP Address">
    </form>
    <script src="./static.js"></script>
</body>
</html>
