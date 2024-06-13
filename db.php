<?php
error_reporting(E_ALL ^ E_DEPRECATED);   
   /* For the following details, ask your server vendor  */
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "timtec_roaster";
    mysqli_connect( $dbhost, $dbuser, $dbpass, $dbname ) or die ( "Unable to connect to MySQL server" );
    //mysqli_select_db( "$dbname" );
    //mysqli_query( "SET NAMES utf8" ); // Set this to latin2 if you're using latin2 collacation in your database
	//$db_handle = mysqli_connect($dbhost, $dbuser, $dbpass);
	//$db_found = mysqli_select_db($dbname, $db_handle);
	
	
include_once("functions.php");
?>