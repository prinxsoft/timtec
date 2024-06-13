<?php
ob_start();
include("header.php");
include("conn.php");
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
   			<a href="#"><h2 class="title"><!--TIMTEC Observers' Page-->TIMTEC Entitlement's Report</h2></a>
            <hr />
   			<br/><!--The invigilation duty roster for this Semester Examination is out. Observers are hereby advised to check here for their invigilation schedules.-->
			
    <?php
	
		/////////
		$sql = " SELECT s.staffSp, CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, d.deptCode from staff s JOIN department d on(s.staffDeptId=d.deptId) where s.active=1 and s.staffCatId=7 and s.staffSp='$staffNmb';" ;
		
		$result_HOD = $db->query($sql);
		if(mysqli_num_rows($result_HOD)>0){ 
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$staffSp = $row['staffSp'] ;
						$staffName = $row['fullname'] ;
						$deptCode = $row['deptCode'] ;
					}
		}
		?>

		<div class="datagrid"> <table class='greenTable'>
					  <thead><tr>
							<th  colspan="12" align="centre"> Outcome of Invigilation Attendance and Staff Entitlement</th>
						</tr></thead>
						<thead><tr>
							<th >S/N</th>
							<th >Dept</th>
							<th> StaffSp</th>
							<th >StaffName</th>
							<th >Total Slot</th>
							<th >Not Marked</th>
							<th >Early Presence</th>
							<th >Late Presence</th>
							<th >Absence</th>
							<th >Rate</th>
							<th >Worth</th>
							<th >Status</th>
						</tr>
						</thead>
						<tfoot>
							<tr>
							<td colspan="12">
		<?php include("pagination.php"); ?>
							</td>
							</tr>
							</tfoot>
						<tbody>
		<?php
		$sql = "SELECT distinct staffSp, staffName, staffDeptCode FROM staffroaster where length(staffSP)>1 order by staffDeptCode,staffSp ;" ;
		
		$result_HOD = $db->query($sql);
		if(mysqli_num_rows($result_HOD)>0){ 
					$serial=1;
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$staffSpInv = $row['staffSp'] ;
						$staffNameInv = $row['staffName'] ;
						$staffDeptCodeInv = $row['staffDeptCode'] ;
						$NotMarkedCounter=0;
										$AbsentCounter=0;
										$LateCounter=0;
										$EarlyCounter=0;
										$totalAttValue=0;
										$mycount=0;
										$value=0;
							$sql2 = "SELECT Presence FROM staffroaster where staffSp='$staffSpInv' order by scheduleDate;" ;
							$result2=mysqli_query($db,$sql2);
							if(!$result2) {
								$message.= 'Invalid query: '. mysql_error() . "\n";
								die($message);
							}
							else{
									
									if(mysqli_num_rows($result2)>0)
									{ 
										
										while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
											
											$Presence = $row2['Presence'] ;
											if($Presence==-1){
												$NotMarkedCounter=$NotMarkedCounter+1;
											}
											else if($Presence>=0){
											
												if($Presence==0){
													$AbsentCounter=$AbsentCounter+1;
												}
												else if($Presence==1){
													$LateCounter=$LateCounter+1;
												}
												else if($Presence==2){
													$EarlyCounter=$EarlyCounter+1;
												}
												$totalAttValue = $totalAttValue + $Presence;
											}
											$mycount++;
										}
										
										/*This function will pass the result and save it in the database
										function entitlementDatabase(){
									$attendancePercentage = ($mycount - $NotMarkedCounter) * 100 / $mycount;

										// Calculate the rate based on staff category
										$rate = (strpos(strtolower($staffNameInv), 'prof') !== false) ? 5000 : 1500;

										// Calculate the attendance percentage
										$attendancePercentage = ($mycount - $NotMarkedCounter) * 100 / $mycount;

										// Calculate the worth based on the rate and attendance percentage
										$worth = ($rate / 100) * $attendancePercentage * $mycount;

										// Prepare the SQL INSERT statement
										$sqlInsert = "INSERT INTO entitlement (staffSp, staffName, staffDept, category, slots, present, early, absent, late, rate, worth) 
													VALUES ('$staffSpInv', '$staffNameInv', '$staffDeptCodeInv', " . (strpos(strtolower($staffNameInv), 'prof') !== false ? "'Prof'" : "'Lecturer'") . ", $mycount, $NotMarkedCounter, $EarlyCounter, $AbsentCounter, $LateCounter, $rate, $worth)";

										// ...
										$resultInsert = mysqli_query($db, $sqlInsert);
										if (!$resultInsert) {
											$message .= 'Error inserting data: ' . mysqli_error($db) . "\n";
											die($message);
												}
										}*/
										
										//Call the function
									 //entitlementDatabase();
									?>
									<tr>
												<td><?php echo $serial;?></td>
												<td><?php echo $staffDeptCodeInv;?></td>
												<td><?php echo $staffSpInv;?></td>
												<td><?php echo $staffNameInv;?></td>
												<td><?php echo $mycount;?><br></td>
												<td><?php echo $NotMarkedCounter;?><br></td>
												<td><?php echo $EarlyCounter;?><br></td>
												<td><?php echo $LateCounter;?><br></td>
												<td><?php echo $AbsentCounter;?><br></td>
												<td><?php echo( (strpos(strtolower($staffNameInv), 'prof' ) !== false)? 5000:1500);?><br></td>
												<td><?php 
												if((strpos(strtolower($staffNameInv), 'prof' ) !== false)){
    												if($EarlyCounter==0 && $LateCounter==0){
    												 $value=0  ;  
    												}
    												else{
    												    $value=10000;
    												}
                            
												}
												else{
												    $value=($totalAttValue*750);
												}
												echo ($value);?><br></td>
												<td><?php echo ((strpos(strtolower($staffNameInv), 'prof' ) !== false)? 'Prof':'Lecturer');?><br></td>
									</tr>
										<?php
										
									}		
									else{
									?>
									<tr>
									<td  colspan="12"><p><?php echo "No Records Match! or No slot Assigned yet ";?></td></tr>
									<?php
									}
									
								  }	
								
					$serial++;			
				}
		}
		?>
		</tbody> </table></div>

			    
<p>For further enquiries, please call the <a href="#"><strong>TIMTEC Secretary:+2348062>>>> | Chairman:+2348039181615</strong></a>. Thanks.</p>
          </div>
   		</div>
<?php
include("footer.php");
?>