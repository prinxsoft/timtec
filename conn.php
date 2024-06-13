<?php
//error_reporting(E_ALL ^ E_DEPRECATED);   
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'timtec_manager');
define('DB_PASSWORD', 'zRz@GcTKj(?Q');
define('DB_DATABASE', 'timtec_2023first');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?>