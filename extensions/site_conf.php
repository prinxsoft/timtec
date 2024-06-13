<?php
	//ob_start();
	session_start();
	include("../dbcon/dbcon.php");

	include_once('site_info_class.php');
	include_once('../site_info_class_client.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Admin Manage Site Info</title>

	<link rel="stylesheet" href="../cssroaster.css">
	<link rel="stylesheet" href="../css/fontawesome-free-6.4.0-web/css/all.css">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/prinxStylesheet.css">

	<script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>

	<script src="../js/scriptor.js"></script>
	
	<link rel="stylesheet" href="../jquery-ui/jquery-ui.min.css">
    <script type="text/javascript" src="../jquery-ui/jquery-ui.min.js"></script>


	<script>
	$(init);

	function init() {
		$('#tabs').tabs();
	}

	</script>

	<style type="text/css">
		<?php
			include_once('background.php');
		?>
		#siteupdate{
			color:tomato;
		}
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
                Site
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
                    require_once('site_article.php');
                ?>

            </div>

<?php
	include("footer.php");
?>
</div>