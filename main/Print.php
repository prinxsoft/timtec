<?php
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Roaster Homepage</title>
<link rel="stylesheet" type="text/css" href="cssroaster.css" />

<script type="text/javascript" language="javascript1.5">
function printNow()
	{
	window.print() ;
	}
</script>
<style type="text/css">
<!--
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
-->
</style></head>

<body onload="printNow()">
<div id="wrapper">

	<div id="headerwrap">
		<div id="header">
		  <img src="../Images/gif/unaabplainBanner.gif" width="965" height="101" alt="funaab" />
		</div>
    </div>
    <div id="navigationwrap">
        <div id="navigation">
        EXAMINATION INVIGILATION DUTY ROSTER<br />
        2020/2021 Session (Second Semester)
      </div>      	
  </div>
<?php
include("../conn.php");

session_start();
$staffNmb=$_SESSION['staffNmb'];
$userType=$_SESSION['userType'];
if(!isset($_SESSION['staffNmb']) || (empty($_SESSION['staffNmb'])))
{
$message="Cannot Find Your Details";
header("location: login.php?error=$message");
exit();
}
else{
	 if($userType==1){
	 //Invigilator
	 $user='Invigilator';
	 }
	 else if($userType==2){
	 //TIMTEC Observers
	 $user='TIMTEC Observer';
	 }
	 else if($userType==3){
	 //HODs
	 $user='HOD';
	 }
	 else if($userType==4){
	 //Chief invigilator
	 $user='Chief Invigilator';
	 }
}
?>
    <div id="fullpagewrap">
   		  <div id="fullPage">
   			<a href="#"><h2 class="title"><?php echo "$user";?>'s Page </h2></a><div class="alignright" style="text-align:right;"> <a href="javascript:window.print();">Print</a> | <a href="../Logout.php">Log-Out</a></div>
            <hr />
		<?php
		if($userType==1){
	 //Invigilator
	 $sql = "SELECT staffName, staffSp, staffDeptCode, scheduleDate, ExamType, Hall, Period FROM staffroaster where staffSp='$staffNmb' order by scheduleDate;" ;
		$result=mysqli_query($db,$sql);
		if(!$result) {
			$message.= 'Invalid query: '. mysql_error() . "\n";
			die($message);
		}
		else{
		?>  <div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="8" align="centre"> Schedule Details of staff: <?php echo "$staffNmb";?></th>
				</tr></thead>
				<thead><tr>
					<th >S/N</th>
					<th >staff</th>
					<th >staffDept</th>
					<th >InvDate</th>
					<th >ExamType</th>
					<th >Hall</th>
					<th >Period</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="8">
<?php include("../pagination.php"); ?>
					</td>
					</tr>
					</tfoot>
				<tbody>
				<?php
				
				if(mysqli_num_rows($result)>0)
				{ 
				$mycount=1;
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$staff = $row['staffName'] ;
					$staffDeptCode = $row['staffDeptCode'] ;
					$InvDate = $row['scheduleDate'] ;
					$ExamType = $row['ExamType'] ;
					$Hall = $row['Hall'] ;
					$Period = $row['Period'] ;
					?>
					<tr>
							<td><?php echo $mycount;?></td>
							<td><?php echo $staff;?></td>
							<td><?php echo $staffDeptCode;?><br></td>
							<td><?php echo $InvDate;?></td>
							<td><?php echo $ExamType;?></td>
							<td><?php echo $Hall;?><br></td>
							<td><?php echo $Period;?><br></td>
					</tr>
					<?php
					$mycount++;
						}
				}
				else{
				?>
				<tr>
				<td  colspan="8"><p><?php echo "No Records Match! ";?></td></tr>
				<?php
				}
				?></tbody> </table></div><?php	
			  }
	 }/*
	 else if($userType==2){
	 //TIMTEC Observers
	 $sql = " SELECT name FROM observer where spNumber='$staffNmb';" ;
		$result_HOD=mysqli_query($db,$sql);
		if(mysqli_num_rows($result_HOD)==1){ 
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$Observer_name = $row['name'] ;
					}
		}
		
		$hodalloc = "SELECT observer, observerSP, observerDept, dDate, observerPeriod, hallGroup FROM observerallocation where observerSP='$staffNmb' order by dDate,observerPeriod;" ;
		$result=mysqli_query($db,$hodalloc);
		if (!$result) {
			$message.= 'Invalid query: ' . mysql_error() . "\n";
			die($message);
		}
		else{
		?>  <div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="8" align="centre" > Schedule Details for TIMTEC Observer: <?php echo $Observer_name;?></th>
				</tr></thead>
				<thead><tr>
					<th >S/N</th>
					<th >observerSP</th>
					<th >observerDept</th>
					<th >InvDate</th>
					<th >Hall</th>
					<th >Period</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="7">
<?php include("pagination.php"); ?>
					</td>
					</tr>
					</tfoot>
				<tbody>
				<?php
				
				if(mysqli_num_rows($result)>0)
				{ 
				$mycount=1;
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$observerSP = $row['observerSP'] ;
					$observerDept = $row['observerDept'] ;
					$dDate = $row['dDate'] ;
					$hallGroup = $row['hallGroup'] ;
					$observerPeriod = $row['observerPeriod'] ;
					?>
					<tr>
							<td><?php echo $mycount;?></td>
							<td><?php echo $observerSP;?></td>
							<td><?php echo $observerDept;?><br></td>
							<td><?php echo $dDate;?></td>
							<td><?php echo $hallGroup;?><br></td>
							<td><?php echo $observerPeriod;?><br></td>
					</tr>
					<?php
					$mycount++;
						}
				}
				else{
				?>
				<tr>
				<td  colspan="7"><p><?php echo "No Records Match! ";?></td></tr>
				<?php
				}
				?></tbody> </table></div><?php	
			  }
	 
	 }*/
	 else if($userType==3){
	 //HODs
	 $sql_HOD = " SELECT deptCode,name FROM department, hod where deptId=departmentId and spNumber='$staffNmb';" ;
		$result_HOD=mysqli_query($db,$sql_HOD);
		if(mysqli_num_rows($result_HOD) == 1){ 
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$Dept = $row['deptCode'] ;
						$hod = $row['name'] ;
					}
		}
		
		$hodalloc = "SELECT staffName, staffSp, staffDeptCode, scheduleDate, ExamType, Hall, Period FROM staffroaster where staffDeptCode='$Dept' order by scheduleDate,Period;" ;
		$result=mysqli_query($db,$hodalloc);
		if (!$result) {
			$message.= 'Invalid query: ' . mysql_error() . "\n";
			die($message);
		}
		else{
		?>  <div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="8" align="centre" > Schedule Details: Department of <?php echo "$Dept";?> headed by <?php echo "$hod";?></th>
				</tr></thead>
				<thead><tr>
					<th >S/N</th>
					<th >staff</th>
					<th >staffSp</th>
					<th >staffDept</th>
					<th >InvDate</th>
					<th >ExamType</th>
					<th >Hall</th>
					<th >Period</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="8">
<?php include("../pagination.php"); ?>
					</td>
					</tr>
					</tfoot>
				<tbody>
				<?php
				
				if(mysqli_num_rows($result)>0)
				{ 
				$mycount=1;
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$staff = $row['staff'] ;
					$staffSp = $row['staffSp'] ;
					$staffDeptCode = $row['staffDeptCode'] ;
					$InvDate = $row['scheduleDate-'] ;
					$ExamType = $row['ExamType'] ;
					$Hall = $row['Hall'] ;
					$Period = $row['Period'] ;
					?>
					<tr>
							<td><?php echo $mycount;?></td>
							<td><?php echo $staff;?></td>
							<td><?php echo $staffSp;?></td>
							<td><?php echo $staffDeptCode;?><br></td>
							<td><?php echo $InvDate;?></td>
							<td><?php echo $ExamType;?></td>
							<td><?php echo $Hall;?><br></td>
							<td><?php echo $Period;?><br></td>
					</tr>
					<?php
					$mycount++;
						}
				}
				else{
				?>
				<tr>
				<td  colspan="8"><p><?php echo "No Records Match! ";?></td></tr>
				<?php
				}
				?></tbody> </table></div><?php	
			  }
	 }
	 /*else if($userType==4){
	 //Chief invigilator
	 $chiefalloc = "SELECT chief, chiefSP, chiefDept, dDate, chiefPeriod, hallGroup FROM chiefallocation where chiefSP='$staffNmb' order by dDate;" ;
		$result=mysqli_query($db,$chiefalloc);
		if (!$result) {
			$message.= 'Invalid query: ' . mysql_error() . "\n";
			die($message);
		}
		else{
		?>  <div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="7"> Schedule Details:<?php echo ": First Semester Examination (2017/2018 Session)";?></th>
				</tr></thead>
				<thead><tr>
					<th >S/N</th>
					<th >chief-Invigilator</th>
					<th >SPNumber</th>
					<th >Department</th>
					<th >ExamDate</th>
					<th >Period</th>
					<th >Hall-Group</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="7">
<?php include("pagination.php"); ?>
					</td>
					</tr>
					</tfoot>
				<tbody>
				<?php
				
				if(mysqli_num_rows($result) == 1)
				{ 
				$mycount=1;
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$chief = $row['chief'] ;
					$chiefSP = $row['chiefSP'] ;
					$chiefDept = $row['chiefDept'] ;
					$dDate = $row['dDate'] ;
					$chiefPeriod = $row['chiefPeriod'] ;
					$hallGroup = $row['hallGroup'] ;
					
					?>
					<tr>
							<td><?php echo $mycount;?></td>
							<td><?php echo $chief;?></td>
							<td><?php echo $chiefSP;?><br></td>
							<td><?php echo $chiefDept;?></td>
							<td><?php echo $dDate;?><br></td>
							<td><?php echo $chiefPeriod;?></td>
							<td><?php echo $hallGroup;?><br></td>
					</tr>
					<?php
					$mycount++;
						}
				}
				else{
				?>
				<tr>
				<td  colspan="7"><p><?php echo "No Records Match! ";?></td></tr>
				<?php
				}
				?></tbody> </table></div><?php	
			  }
	 }*/
		
			 ?>
			    
<p>For further enquiries, please call the <a href="#"><strong>TIMTEC Secretary:+2348060743664 | Chairman:+2348039181615</strong></a>. Thanks.</p>
          </div>
   		</div>
<?php
include("../footer.php");
?>