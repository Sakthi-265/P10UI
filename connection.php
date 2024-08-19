<?php      
    $host = "localhost";  
    $user = "Sakthi";  
    $password = '';  
    $db_name = "sakthi";  
      
    $con = new mysqli($host, $user, $password, $db_name);  
    if(mysqli_connect_error()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    } 
   
    
?>  
