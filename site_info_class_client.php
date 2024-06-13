<?php
// Assuming you have a valid database connection in the $conn variable

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

$site = new Site($db);

// Retrieve all fields
$allData = $site->getSiteInfo();
//print_r($allData);

// Retrieve specific fields
$specificData = $site->getSiteInfo(['name', 'session']);
//print_r($specificData);

// Retrieve a single field
$name = $site->getSiteInfo(['session']);
$semester = $site->getSiteInfo(['current_semester']);
$comp_ddate = $site->getSiteInfo(['dead_date_comp']);
$con = $site->getSiteInfo(['contact1']);
$con2 = $site->getSiteInfo(['contact2']);
$grp = $site->getSiteInfo(['name']);
$inst = $site->getSiteInfo(['institution']);
//echo $name['session'];
?>