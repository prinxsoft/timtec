<?php
	//ob_start();
	session_start();
	include("../dbcon/dbcon.php");

	include_once('site_info_class.php');
	include_once('../site_info_class_client.php');
	//echo $_SESSION['super_admin'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>login</title>

	<link rel="stylesheet" href="../cssroaster.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/prinxStylesheet.css">
	<script src="../js/jquery-3.6.0.min.js"></script>
	<script src="../js/bootstrap.bundle.js"></script>
	<script src="../js/scriptor.js"></script>
	<script src="../js/prinx_fadein.js"></script>


	<style type="text/css">
		<?php
			include_once('background.php');
		?>
		
	</style>
	</head>
	<body>
		<?php
		//banner's module
		include_once('adminBanner.php');
		?>
		<div class="container-fluid">
            <div class="row">
			<div class="col-sm-4 bg-primary text-white rounded">
				Logged-In: <?php 
					if(empty($_SESSION['spnumber'])){
						header('location: timtec_admin.php');
						exit();
					}else{
						echo $_SESSION['spnumber']; 
					}
					?>
                </div>
                <div class="col-sm-4 bg-primary text-white text-center rounded">
					Home
                </div>
                <div class="col-sm-4 text-end bg-primary text-white rounded">
					<div class="row">
						<div class="col-sm-6">
							<?= $grp['name'] ?>
						</div>
						<div class="col-sm-6">
							<a href='../Logout_admin.php' id='logout'>Logout</a>
						</div>
					</div>
                </div>
            </div>
            <div class="row">
                
                <?php
                //side link here
                    include_once('land_sidelink.php');
                ?>

                <?php
                    require_once('land_article.php');
                ?>

            </div>

<?php
	include("footer.php");
?>
</div>