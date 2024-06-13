<?php
ob_start();

include_once('dbcon/dbcon.php');

include_once('extensions/site_info_class.php');
include_once('site_info_class_client.php');
include("header.php");
include_once("functions.php");

$message=null;
$Observer_name  ='';

session_start();

$staffNmb=$_SESSION['staffNmb'];
$userType=$_SESSION['userType'];

if(!isset($_SESSION['staffNmb']) || (empty($_SESSION['staffNmb'])))
{
$message="Cannot Find Your Details";
header("location: login.php?error=$message");
exit();
}

global $recordCounter, $count,$staffName,$deptCode,$message;
$staffName=null;
$deptCode=null;
$recordCounter= array();

?>

    <div id="fullpagewrap">
   		  <div id="fullPage">
   			<a href="#"><h2 class="title">TIMTEC Observers' Roster Page </h2></a>
            <hr />
   			<br/>The invigilation duty roster for this Semester Examination is out. Observers are hereby advised to check here for their invigilation schedules. <br/>However, it is necessary to note that schedules are displayed on your dashboard ONLY on the assigned dates of your appointment/observation.
   			<div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="5" align="centre"> Details of Observer's Schedule</th>
				</tr>
				<tr>
					<th >S/N</th>
					<th >InvDay</th>
					<th >InvDate</th>
					<th >Observer Period</th>
					<th >Hall Category</th>
					<th >Exam Type</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="5">
<?php include("pagination.php"); ?>
					</td>
					</tr>
					</tfoot>
				<tbody>
					
			<?php 
			
			$sql_tim = "SELECT day, dDate, observerPeriod, hallGroup FROM observerallocation WHERE observerSP = '{$_SESSION['staffNmb']}';";


			$result_tim = $db->query($sql_tim);
			if(mysqli_num_rows($result_tim)>0){ 
						$itr=1;
						while($row1 = mysqli_fetch_array($result_tim,MYSQLI_ASSOC)){
							$Tim_day = $row1['day'] ;
							$Tim_dDate = $row1['dDate'] ;
							$Tim_observerPeriod = $row1['observerPeriod'] ;
							$Tim_hallGroup = $row1['hallGroup'] ;
							?>
							<tr>
							<td><?php echo $itr;?></td>
							<td><?php echo $Tim_day;?><br></td>
							<td><?php echo $Tim_dDate;?></td>
							<td><?php echo $Tim_observerPeriod;?><br></td>
							<td><?php echo $Tim_hallGroup;?></td>
							<td>
							    <?php
							        $sql_tt = "SELECT Period, ExamType from staffroaster where hallCatTimtec='$Tim_hallGroup' AND scheduleDate='$Tim_dDate' LIMIT 1;";
							        $result_tt = $db->query($sql_tt);
							        if (mysqli_num_rows($result_tt)>0){
							            while ($rw = mysqli_fetch_array($result_tt,MYSQLI_ASSOC)){
							            $per = $rw['Period'];
							            $ExamType = $rw['ExamType'];
							            echo $ExamType;
							            }
							        }
							    ?>
							</td>
							</tr>
							<?php
							$itr++;
						}
			}//selection ends
			else{
				?>
				<tr>
				<td  colspan="9"><p><?php echo "No Invigilation Schedule Alloted yet| Today is not an Exam Date, contact TIMTEC ";?></td></tr>
				<?php
				}
			?></tbody></table></div>
			<br/>Steps for Marking:
				<ul>
				<li>Verify staff details and presence</li>
				<li>Click on the Radio button to take appropriate action (i.e Present, Late, Absent)</li>
				<li>Click on 'Mark Attendance' button to Save action taken</li>
				<li> Proceed immediately to Click on 'Finalize' button and 'Verify' Link to commit and verify your action </li>
				<li>Click on 'Go To Previous' Link If you wish to continue Marking otherwise Logout your Session</li>
				</ul>
				Summarily put, follow this steps in this order:
		<font color="red">[Select Radio Button ==>Click 'Mark Attendance'==>Click 'Finalize'==>Click 'Verify']</font>
		<hr><div class="container m-2">
		    <label for="search" class="bg-success text-white h4">Search: </label>
		    <input type="text" id="search" class="form-control form-contol-lg" placeholder="Ser.No/Date/Name/spNumber/Hall...">
		    <span id="recordCount" class="bg-info"></span>
		</div>
    <?php
	
		$sql = " SELECT s.staffSp, CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, d.deptCode from staff s JOIN department d on(s.staffDeptId=d.deptId) where s.active=1 and s.staffCatId=4 and s.staffSp='{$_SESSION['staffNmb']}';" ;
		
		$result_HOD = $db->query($sql);
		if(mysqli_num_rows($result_HOD)>0){ 
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$staffSp = $row['staffSp'] ;
						$staffName = $row['fullname'] ;
						$deptCode = $row['deptCode'] ;
					}
		}
		$timtecalloc = "SELECT  s.staffRoasterId, s.staffSp,s.staffName,  s.staffDeptCode,s.scheduleDate, s.ExamType, s.Hall,  s.hallCatTimtec,s.Period, s.Presence, s.hasObserver FROM staffroaster s, observerallocation o where s.day=o.day and s.hallCatTimtec=o.hallGroup and s.mainPeriod=o.observerPeriod and o.observerSP='{$_SESSION['staffNmb']}' and length(s.staffSP)>1 and s.scheduleDate<=CURRENT_DATE AND CURTIME() <= '21:00:00' order by s.scheduleDate,s.staffRoasterId,o.observerPeriod;" ;
	//	$timtecalloc = "SELECT  s.staffRoasterId, s.staffSp,s.staffName,  s.staffDeptCode,s.scheduleDate, s.ExamType, s.Hall,  s.hallCatTimtec,s.Period,  s.Presence FROM staffroaster s, observerallocation o where s.day=o.day and s.hallCatTimtec=o.hallGroup and s.mainPeriod=o.observerPeriod and o.observerSP='$staffNmb' and length(s.staffSP)>1 order by s.scheduleDate,s.staffRoasterId,o.observerPeriod;" ;
		
		$result=mysqli_query($db,$timtecalloc);
		if (!$result){
			$message.= 'Invalid query: ' . mysql_error() . "\n";
			die($message);
		}
		else{
		?>
		<div class="datagrid"> <form name="mark" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]);?>" method="post">
		<table class='greenTable'>
			  <thead><tr>
					<th  colspan="10" align="centre" > Schedule Details for TIMTEC Observer: <?php echo $staffName.'['.$staffNmb.'|'.$deptCode.']';?></th>
					 <?php if(!empty($message)) echo "<th  colspan='10' align='centre' >$message</th>";?>
				</tr></thead>
				<thead><tr>
					<th >S/N</th>
					<th >Date</th>
					<th >InvSP</th>
					<th >InvName</th>
					<th >InvDept</th>
					<th >Exam</th>
					<th >Hall</th>
					<th >Prd</th>
					<th >Class</th>
					<th >Status</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="10">
<?php include("pagination.php"); ?>
					</td>
					</tr>
					</tfoot>
				<tbody>
				<?php
				$count=mysqli_num_rows($result);
				if($count>0)
				{ 
				$mycount=1;
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					
					$staffRoasterId=$row['staffRoasterId'] ;
					$staffSp = $row['staffSp'] ;
					$staffName = $row['staffName'] ;
					$staffDeptCode = $row['staffDeptCode'] ;
					$scheduleDate = $row['scheduleDate'] ;
					$ExamType = $row['ExamType'] ;
					$Hall = $row['Hall'] ;
					//$hallCatTimtec = $row['hallCatTimtec'] ;
					$Period = $row['Period'] ;
					//$observerPeriod = $row['observerPeriod'] ;
					$Presence = $row['Presence'] ;
					$hasObserver = $row['hasObserver'] ;
					$NamePresence='presence'.$staffRoasterId;
					$recordCounter[$mycount-1]= $staffRoasterId;
					?>
					<tr>
							<td><?php echo $mycount;?></td>
							<td><?php echo $scheduleDate;?><br></td>
							<td><?php echo $staffSp;?></td>
							<td><?php echo $staffName;?><br></td>
							<td><?php echo $staffDeptCode;?></td>
							<td><?php echo $ExamType;?><br></td>
							<td><?php echo $Hall;?><br></td>
							<td><?php echo $Period;?><br></td>
							<td><?php echo ($hasObserver==1)? "Lead Invigilator":"Invigilator";?><br></td>
							
							<td><div data-role="fieldcontain">
                            <fieldset data-role="controlgroup">
                                <input type="radio" name="<?php echo $NamePresence; ?>" <?php echo (isset($Presence) && $Presence == 2) ? "checked" : ""; ?> <?= chkDate($scheduleDate); ?> value="2"/>Present </br>
                                <input type="radio" name="<?php echo $NamePresence; ?>" <?php echo (isset($Presence) && $Presence == 1) ? "checked" : ""; ?> <?= chkDate($scheduleDate); ?> value="1" />Is_Late </br>
                                <input type="radio" name="<?php echo $NamePresence; ?>" <?php echo (isset($Presence) && $Presence == 0) ? "checked" : ""; ?> <?= chkDate($scheduleDate); ?> value="0" />Absent</br>
                            </fieldset>
	        </div> 
									</td>
					</tr>
					<?php
					$mycount++;
						}
						$link="ObserverAttendance.php?";
						//$link_Print="../Print.php?";
						//$link="ObserverAttendance.php?";
						$link_Print="main/Print.php?";
						?>
						<!--comment this line when no marking|just for view-->
					 <tr>  <td colspan="4"><input type="submit" name="submit" class="submit" value="Mark Attendance" /></td><td colspan="3"><a href="<?php  echo $link;?>"> <input type="submit"  class="submit" name="finalize" value="Finalize" /></a></td><td colspan="3"><a href="ObserverAttendance.php" class="submit"><font color="#FFFFFF"> Verify</font></a></td></tr></tr>
				<?php }
				else{
				?>
				<tr>
				<td  colspan="10"><p><?php echo "No Invigilation Schedule Alloted/Visible yet| Today is not an Exam Date! Try Again on Exam Day! $staffNmb";?></td></tr>
				<?php
				}
				?></tbody> </table></form></div><?php	
			  }
			if(isset($_POST["submit"])){
			$incount=0;
			$failed=0;
			for ($i=0; $i<$count; $i++){
			 $item= $recordCounter[$i];
			 $NamePresence='presence'.$item ;
			 if(isset($_POST["$NamePresence"]) ){
				$id = mysqli_real_escape_string($db,$item);
				$Presence = $_POST["$NamePresence"];
				$Presence = mysqli_real_escape_string($db, $Presence);
				$sql_post = "UPDATE staffroaster SET presence =$Presence, timtecMarker='$staffNmb', DatetimeTimMarked=now() WHERE staffRoasterId =$id ;";
				
				$result2= $db->query($sql_post);
				if($result2){
					$incount=$incount+1;
				}
				
				
			 }
			 }
			 //echo "<div><font style='font-size:15px; margin-left:10px; color:green'>$message</font></div>";
			 $_SESSION['incount']=$incount;
	        }
			 
			 ?>
			    
                <?php echo "$ContactLine";?>
                <p>Thanks.</p>
          </div>
          <?php
            function chkDate($date) {
                if ($date < date('Y-m-d')) {
                    //return 'disabled'; // or 'disabled'
                }
                return ''; // Empty string if the condition is not met
            }

          ?>
   		</div>
<?php
include("footer.php");
?>
