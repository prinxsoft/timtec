<?php
session_start();
session_destroy();
include_once('dbcon/dbcon.php');

include_once('extensions/site_info_class.php');
include_once('site_info_class_client.php');
include_once("functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Examination Roster</title>
	
	<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="/faviconsafari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	
	<link rel="stylesheet" type="text/css" href="cssroaster.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/prinxStylesheet.css">
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/scriptor.js"></script>
	<script src="js/prinx_fadein.js"></script>
	
<style type="text/css">
	<?php
		include_once('extensions/background.php');
	?>
	

</style>
<script>
    
</script>
</head>

<body>

<?php
//banner's module
	include_once('extensions/banner.php');
?>


<div id="overall" class="container">

	<!-- the minor header starts -->
		<?php
			include_once('extensions/header.php');
		?>
		<!-- The minor header ends -->

		
		<div class="row">
			
			<?php
			//side link here
				include_once('extensions/sidelink.php');
			?>

			<?php
			//articles here
				require_once('extensions/article.php');
			?>
			
            <?php
				require_once('whatsapp_extension.php');
			?>
			
		</div>
    		
    </div>

<?php
//footer module
	include_once('extensions/footer.php');
?>

</body>
</html>