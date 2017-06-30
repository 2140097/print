<?php
//variables for connecting to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "print";

//connect to database using variables
$conn = new mysqli($servername, $username, $password, $dbname);

//connection error
if (!$conn) {
    die("Connection failed: ". mysqli_connection_error());
}  

//connection close

?>