<?php
include_once('extensions/site_info_class.php');
include_once('site_info_class_client.php');
include_once("functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Roster Homepage</title>

    <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="/faviconsafari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="cssroaster.css" />
<style type="text/css">

a:link {
	color: #060;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #3C0;
}
a:hover {
	text-decoration: underline;
	color: #0C0;
}
a:active {
	text-decoration: none;
	color: #0C0;
}

.mark{
 border-radius:3px; 
 border-color:#FFC;
}
.mark:hover{
    background-color:#FFF;
    color:#00F;
}
#search{
    width:80%;
}

-->
</style>



</head>

<body>
<div id="wrapper">

	<div id="headerwrap">
		<div id="header">
		  <img src="Images/FunaabBanner.PNG" width="965" height="101" alt="funaab" />
		</div>
    </div>
    <div id="navigationwrap">
        <div id="navigation">
        TIME-TABLE & EXAMINATION COMMITEE (TIMTEC) PORTAL
		<br />
        <?= $name['session']?> Session (<?= $semester['current_semester'] ?>)
      </div>
         	<div>
         	<div> TODAY<?php $today = date(" l jS F, Y ") ;  echo(": ".$today); ?></div> <div class="alignright" style="text-align:right;" > <a href="index.php">[Home]</a> | <a href="Logout.php">[Log-Out]</a></div>
            </div>
  </div>