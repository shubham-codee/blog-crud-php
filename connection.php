<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "crud";

//create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);

//check connection
if (!$conn)
    die("connection failed" . mysqli_connect_error());
