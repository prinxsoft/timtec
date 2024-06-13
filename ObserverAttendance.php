<?php
ob_start();
include("header.php");
include("conn.php");
include_once("functions.php");

$message=null;
session_start();
$staffNmb=$_SESSION['staffNmb'];
$userType=$_SESSION['userType'];
$incount=$_SESSION['incount'];
if(!isset($_SESSION['staffNmb']) || (empty($_SESSION['staffNmb']))){
$message="Cannot Find Your Details";
header("location: login.php?error=$message");
exit();
}
function getRemark($value){
	$outcome='';
	if($value==2){
		$outcome='Early Presence';
	}
	elseif($value==1){
		$outcome='Late Presence';
	}
	else if($value==0){
		$outcome='Absent';
	}
	else{
		$outcome='Not Treated';
	}
	return $outcome;
}
?>
    <div id="fullpagewrap">
   		  <div id="fullPage">
   			<a href="#"><h2 class="title">Invigilators' Review Page </h2></a>
            <hr />
   			<p><?php echo"<font style='font-size:15px; margin-left:10px; color:green'>Kindly Verify the marking you just did few seconds ago. $incount staff successfully Marked so far!</font>";?>
				
			</p>
             <!--search subsystem -->
            <hr><div class="container m-2">
		    <label for="search" class="bg-success text-white h4">Search: </label>
		    <input type="text" id="search" class="form-control form-contol-lg" placeholder="Ser.No/Date/Name/spNumber/Hall...">
		    <span id="recordCount" class="bg-info"></span>
		</div>
            
		<?php
		$sql = " SELECT s.staffSp, CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, d.deptCode from staff s JOIN department d on(s.staffDeptId=d.deptId) where s.active=1 and s.staffCatId=4 and s.staffSp='$staffNmb';" ;
		//$result_HOD=mysqli_query($db,$sql);
		$result_HOD = $db->query($sql);
		if(mysqli_num_rows($result_HOD)>0){ 
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$staffSp = $row['staffSp'] ;
						$staffName = $row['fullname'] ;
						$deptCode = $row['deptCode'] ;
					}
		}
		
		//$timtecalloc = "SELECT  s.scheduleDate, s.Hall, s.staffName, s.staffSp,  s.staffDeptCode,  s.Period, s.Presence FROM staffroaster s, observerallocation o where s.day=o.day and s.hallCatTimtec=o.hallGroup and s.mainPeriod=o.observerPeriod and o.observerSP='$staffNmb' and length(s.staffSP)>1 and s.scheduleDate=CURRENT_DATE order by s.scheduleDate,s.staffRoasterId,o.observerPeriod;" ;
		if($userType>4){
		   $timtecalloc = "SELECT  s.scheduleDate, s.Hall, s.staffName, s.staffSp,  s.staffDeptCode,  s.Period, s.Presence FROM staffroaster s, observerallocation o where s.day=o.day and s.hallCatTimtec=o.hallGroup and s.mainPeriod=o.observerPeriod and length(s.staffSP)>1  order by s.scheduleDate,s.staffRoasterId,o.observerPeriod;" ; 
		}
		else{
		    $timtecalloc = "SELECT  s.scheduleDate, s.Hall, s.staffName, s.staffSp,  s.staffDeptCode,  s.Period, s.Presence, s.hasObserver FROM staffroaster s, observerallocation o where s.day=o.day and s.hallCatTimtec=o.hallGroup and s.mainPeriod=o.observerPeriod and o.observerSP='$staffNmb' and length(s.staffSP)>1  order by s.scheduleDate,s.staffRoasterId,o.observerPeriod;" ;

		}
		
		$result=mysqli_query($db,$timtecalloc);
		if (!$result) {
			$message.= 'Invalid query: ' . mysql_error() . "\n";
			die($message);
		}
		else{
		?> 
		 <div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="9" align="centre"> Details of Staff and Schedule under the supervision of : <?php echo "$staffName"."(".$staffNmb.")"." | Dept:$deptCode";?></th>
				</tr>
				<tr>
					<th >S/N</th>
					<th >InvDate</th>
					<th >hall</th>
					<th >staff</th>
					<th >staffSp</th>
					<th >StaffDept</th>
					<th >Period</th>
					<th >Status</th>
					<th >Remark</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="9">
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
					//s.scheduleDate, s.ExamType, s.Hall, s.hallCat1,s.staffName, s.staffSp,  s.staffDeptCode,  s.Period
					$scheduleDate = $row['scheduleDate'] ;
					$Hall = $row['Hall'] ;
					$staffName = $row['staffName'] ;
					$staffSp = $row['staffSp'] ;
					$staffDeptCode = $row['staffDeptCode'] ;
					$Period = $row['Period'] ;
					$Presence = $row['Presence'] ;
					$hasObserver = $row['hasObserver'] ;
					$remark =getRemark($Presence);
					?>
					<tr>
							
							<td><?php echo $mycount;?></td>
							<td><?php echo $scheduleDate;?><br></td>
							<td><?php echo $Hall;?><br></td>
							<td><?php echo $staffName;?><br></td>
							<td><?php echo $staffSp;?></td>
							<td><?php echo $staffDeptCode;?></td>
							<td><?php echo $Period;?><br></td>
							<td><?php echo ($hasObserver==1)?"Lead Invigilator":"Invigilator";?></td>
							<td><?php echo $remark;?></td>
							
					</tr>
					<?php
					$mycount++;
						}?>
						<tr>
				<td  colspan="6" ></td><td  colspan="3"><a href="SchedulePerObserver.php" class="submit"> <font  color="#FFFFFF"> Go Back to Previous </font></a></td></tr>
				<?php 
				}
				else{
				?>
				<tr>
				<td  colspan="9"><p><?php echo "No Records Match! ";?></td></tr>
				<?php
				}
				?></tbody> </table></div><?php	
			  }
			 ?>
			    
                <?php echo "$ContactLine";?>
                <p>Thanks.</p>
            </div>
            
   		</div>
   		
<?php
include("footer.php");
?>