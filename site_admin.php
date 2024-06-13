<?php
	//ob_start();
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
	<title>login</title>

	<link rel="stylesheet" href="cssroaster.css">
	<link rel="stylesheet" href="css/fontawesome-free-6.4.0-web/css/all.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/prinxStylesheet.css">

	<script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

	<script src="js/scriptor.js"></script>
	
	<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
    <script type="text/javascript" src="jquery-ui/jquery-ui.min.js"></script>


	<script>
	$(init);

	function init() {
		$('#tabs').tabs();
	}

	</script>

	<style type="text/css">
		<?php
			include_once('extensions/background.php');
		?>
		#siteupdate{
			color:tomato;
		}
	</style>
	</head>
	<body>
		<?php
		//banner's module
			include_once('extensions/banner.php');
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
                Admin/TIMTEC Users:
                </div>
                <div class="col-sm-4 text-end bg-primary text-white rounded">
                    <?= $grp['name'] ?>
                </div>
            </div>
            <div class="row">
                
                <?php
                //side link here
                    include_once('extensions/land_sidelink.php');
                ?>

                <?php
                    require_once('extensions/admin_users.php');
                ?>

            </div>

<?php
	include("extensions/footer.php");
?>
</div>