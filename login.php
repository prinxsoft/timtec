<?php
	ob_start();
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
	<title>login</title>

    <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="/faviconsafari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" href="cssroaster.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
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
	 $(document).ready(function() {
        $('.btn-close').click(function() {
        $('.message').fadeOut();
    });
});

	</script>
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
			//articles here
			$message=null;
			if( isset($_POST["submitLogin"])){
					if(empty($_POST["spNumber"])){
						$message="Staff Number cannot be Empty!"." "."<i class='fa fa-exclamation-circle'></i>";
					}
					else{
						$spNumber = $_POST["spNumber"];
						$spNumber = strtoupper(stripslashes($spNumber));
						$spNumber = mysqli_real_escape_string($db, $spNumber);
						
                        $spNumber = preg_replace('/\s+/', '', $spNumber);
                        

						$sql="SELECT spNumber, userType FROM users WHERE spNumber='$spNumber' ;";
						$result=mysqli_query($db,$sql);
						$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
						if(mysqli_num_rows($result) == 1)
							{	
								$staffNmb = $row['spNumber'] ;
								$userType = $row['userType'] ;
								session_start();
								$_SESSION['staffNmb']=$staffNmb;
								$_SESSION['userType']=$userType;
								if($userType==1 || $userType==2){
									   header("Location: SchedulePerStaff.php");
									exit();
								}
								elseif($userType==4){
									header("location: SchedulePerObserver.php");
									exit();
								}
								else if($userType==3){
									header("Location: SchedulePerDepartment.php");
									exit();
								}
								else if($userType==5){
									header("Location: extendedMarking.php");
									exit();
								}
								else if($userType==7){
									header("Location: MarkingAll.php");
									exit();
								}
						 }
							else {
							 $message="Wrong Staff Number"." "."<i class='fa fa-exclamation-circle'></i>";
							 
							}
					}
				}
				else{
					if(!isset($_GET['error']) || empty($_GET['error'])){
						$message=" Kindly Provide Your Login Credential";
					}
					else{
					$message=$_GET['error']." "."<i class='fa fa-exclamation-circle'></i>";
					}
				}
			
				require_once('extensions/form_in.php');
			?>
            
             <?php
				require_once('whatsapp_extension.php');
			?>
            
		</div>

<?php
	include("extensions/footer.php");
?>