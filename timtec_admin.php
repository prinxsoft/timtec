<?php
	ob_start();
	session_start();
	include("dbcon/dbcon.php");
	include_once('extensions/site_info_class.php');
	include_once('site_info_class_client.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Admin login</title>
	
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="/faviconsafari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	
	<link rel="stylesheet" href="cssroaster.css">
	<link rel="stylesheet" href="css/fontawesome-free-6.4.0-web/css/all.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/prinxStylesheet.css">
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/scriptor.js"></script>
	<script src="js/prinx_fadein.js"></script>


	<style type="text/css">
<?php
//include_once('extensions/background.php');
$bck = file_get_contents('extensions/background.php');
echo $bck;
?>
	</style>
</head>
	<body>
<?php
		//banner's module
include_once('extensions/banner.php');
?>
		<div id="overall" class="container">

		<div class="row">
			
<?php
			//side link here
include_once('extensions/sidelink.php');
?>
<?php
$message = null;

if (isset($_POST['submitLogin'])){
	if (empty($_POST['spNumber'])){
		//spnumber not set
	$message ='Spnumber is not set';
	}else{
		//sp number set
		$spNumber = $_POST["spNumber"];
		$spNumber = strtoupper(stripslashes($spNumber));
		$spNumber = mysqli_real_escape_string($conn, $spNumber);

		$stmt = $conn->prepare("SELECT * FROM timtec WHERE staff_id = ?");
		$stmt->bind_param("s", $spNumber);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$_SESSION['spnumber'] = $spNumber;
			while($row=$result->fetch_assoc()){
				$_SESSION['super_admin']=$row['super_admin'];
			}
			header('location: extensions/land_page.php');
			exit();
		}else{
			$message = 'Record does not exist';
		}

		$stmt->close();
		$conn->close();

	}
}else{

}

?>
<?php
	require_once('extensions/admin_login.php');
?>
        <?php
				require_once('whatsapp_extension.php');
		?>
		</div>

<?php
	include("extensions/footer.php");
?>