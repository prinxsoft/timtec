<?php
$host = 'localhost';
$user = 'timtec_manager';
$pwd = 'zRz@GcTKj(?Q';
$database = 'timtec_2023first';
$conn = new mysqli($host,$user,$pwd,$database);
$db=$conn;


if ($conn->connect_error){
    die('Unable to connect to the database '.$conn->connect_errno);
}

?>