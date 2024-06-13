<?php
include("header.php");
include("conn.php");
$message=null;
session_start();
$staffNmb=$_SESSION['staffNmb'];
$userType=$_SESSION['userType'];
if(!isset($_SESSION['staffNmb']) || (empty($_SESSION['staffNmb'])))
{
$message="Cannot Find Your Details";
header("location: login.php?error=$message");
exit();
}
?>
    <div id="fullpagewrap">
   		  <div id="fullPage">
   			<a href="#"><h2 class="title">Chief Invigilators' Page </h2></a>
            <hr />
   			<p>The Invigilation Duty roaster for this Semester Examination is out. Invigilators are hereby advised to check here for their schedules.</p>
            
		<?php
		$sql = " SELECT name, deptCode FROM chief, department where departmentId=deptId and spNumber='$staffNmb';" ;
		$result_HOD=mysqli_query($db,$sql);
		if(mysqli_num_rows($result_HOD)==1){ 
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$chief_name = $row['name'] ;
						$chief_dept = $row['deptCode'] ;
					}
		}
		
		$sql = "SELECT chiefName, chiefSp, chiefDept, InvDate, examType, hall, hallCat, staff, staffSp, StaffDept, chiefPeriod FROM chiefattendance where chiefSp='$staffNmb' order by InvDate,examType, hall, staffSp;" ;
		$result=mysqli_query($db,$sql);
		if(!$result) {
			$message.= 'Invalid query: '. mysql_error() . "\n";
			die($message);
		}
		else{
		?>  <div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="9" align="centre"> Schedule Details of staff: <?php echo "$chief_name"."(".$staffNmb.")"." | Dept:$chief_dept";?></th>
				</tr></thead>
				<thead><tr>
					<th >S/N</th>
					<th >InvDate</th>
					<th >ExamType</th>
					<th >hall</th>
					<th >hallCat</th>
					<th >staff</th>
					<th >staffSp</th>
					<th >StaffDept</th>
					<th >Period</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
					<td colspan="9">
					<?php
						include("pagination.php");
					?>
					</td>
					</tr>
					</tfoot>
				<tbody>
				<?php
				
				if(mysqli_num_rows($result)>0)
				{ 
				$mycount=1;
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$InvDate = $row['InvDate'] ;
					$ExamType = $row['examType'] ;
					$Hall = $row['hall'] ;
					$hallCat = $row['hallCat'] ;
					$staff = $row['staff'] ;
					$staffSp = $row['staffSp'] ;
					$StaffDept = $row['StaffDept'] ;
					$ObserverPeriod = $row['chiefPeriod'] ;
					?>
					<tr>
							
							<td><?php echo $mycount;?></td>
							<td><?php echo $InvDate;?><br></td>
							<td><?php echo $ExamType;?></td>
							<td><?php echo $Hall;?><br></td>
							<td><?php echo $hallCat;?></td>
							<td><?php echo $staff;?><br></td>
							<td><?php echo $staffSp;?></td>
							<td><?php echo $StaffDept;?></td>
							<td><?php echo $ObserverPeriod;?><br></td>
							
					</tr>
					<?php
					$mycount++;
						}?>
						<tr>
				<td  colspan="6" ></td><td  colspan="3"><a href="../SchedulePerChief.php"> <<[Backward]</a></td></tr>
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
			    
<p>For further enquiries, please call the <a href="#"><strong>TIMTEC Secretary:+2348062903134 | Chairman:+2348039181615</strong></a>. Thanks.</p>
          </div>
   		</div>
<?php
include("footer.php");
?>