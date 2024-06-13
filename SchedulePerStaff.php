<?php
ob_start();
include("conn.php");
include_once('extensions/site_info_class.php');
include_once('site_info_class_client.php');

include("header.php");
include_once("functions.php");
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
   			<div><div class="alignleft" style="text-align:left; margin: 5px 5px 5px 5px;"><a href="#"> Staff View: Invigilators' Page </a></div> <div class="alignright" style="text-align:right;" > <a href="#"><?php echo 'User:['.$staffNmb.']';?></a></div></div>
            <hr />
            
          <p>
               Below are details of your Invigilation Schedule. Kindly note the Dates and Halls on your Schedule. 
               We hope you have a hitch-free and successful invigilation.
            </p> 
           <!-- <p>
               The Management and TIMTEC appreciates all Members of Staff for their diligence and cooperation towards the success of the 2020/2021 Second Semester Examination. </p> 
                <p>Check here for the outcome of the schedules as you fared. However, your Invigilation Duty roster for the period under consideration is enlisted alongside for your verification.</p> -->
        <p>Peradventure there are valid complaints regarding your schedule, kindly contact TIMTEC Secretary on or before <?= $comp_ddate['dead_date_comp'];?> for further clarification.
                </p> 
            <!--search subsystem -->
            <hr><div class="container m-2">
		    <label for="search" class="bg-success text-white h4">Search: </label>
		    <input type="text" id="search" class="form-control form-contol-lg" placeholder="Ser.No/Date/Name/spNumber/Hall...">
		    <span id="recordCount" class="bg-info"></span>
		</div>
            
		<?php
		//global $status;
		$sql = "SELECT staffName, staffSp, staffDeptCode, scheduleDate, ExamType, Hall, Period, Presence, hasObserver FROM staffroaster where staffSp='$staffNmb' order by scheduleDate;" ;
		$result=mysqli_query($db,$sql);
		if(!$result) {
			$message.= 'Record does not exist: '. mysql_error() . "\n";
			die($message);
		}
		else{
		    
		?>  <div class="datagrid"> <table class='greenTable'>
			  <thead><tr>
					<th  colspan="8" align="centre"> Schedule Details of staff: <?php echo "$staffNmb";?></th>
				</tr></thead>
				<thead><tr>
					<th >S/N</th>
					<th >InvDate</th>
					<th> Name</th>
					<th >ExamType</th>
					<th >Hall</th>
					<th >Period</th>
					<th >Remark</th>
					<th >Status</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8">
							<?php include("pagination.php"); ?>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php
				$NotMarkedCounter=0;
				$AbsentCounter=0;
				$LateCounter=0;
				$EarlyCounter=0;
				$totalAttValue=0;
				if(mysqli_num_rows($result)>0)
				{ 
				$mycount=1;
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$InvDate = $row['scheduleDate'] ;
					$ExamType = $row['ExamType'] ;
					$staffName = $row['staffName'] ;
					$Hall = $row['Hall'] ;
					$Period = $row['Period'] ;
					$Presence = $row['Presence'] ;
					$hasObserver = $row['hasObserver'] ;
					$status = ($hasObserver ==1)? 'Lead Observer : <a href="FORM01.docx"> Download EMR FORM</a>  ':'Invigilator';
					if($Presence==-1){
						$PresenceStatus='Attendance Not Marked';
						$NotMarkedCounter=$NotMarkedCounter+1;
					}
					else if($Presence>=0){
					
						if($Presence==0){
							$PresenceStatus='Absent';
							$AbsentCounter=$AbsentCounter+1;
						}
						else if($Presence==1){
							$PresenceStatus='Late Presence';
							$LateCounter=$LateCounter+1;
						}
						else if($Presence==2){
							$PresenceStatus='Early Presence';
							$EarlyCounter=$EarlyCounter+1;
						}
						$totalAttValue = $totalAttValue + $Presence;
					}
					
					
					?>
					<tr>
							<td><?php echo $mycount;?></td>
							<td><?php echo $InvDate;?></td>
							<td><?php echo $staffName;?></td>
							<td><?php echo $ExamType;?></td>
							<td><?php echo $Hall;?><br></td>
							<td><?php echo $Period;?><br></td>
							<td><?php echo $PresenceStatus; //'NA' $PresenceStatus;?><br></td>
							<td><?php echo $status;?><br></td>
					</tr>
					<?php
					$mycount++;
						}
						$link_Print="main/Print.php?";
						?>
					<tr> <td  colspan="8"></td></tr>
					<tr> <td  colspan="8"><b>Summary: Outcome of Schedule Attendance</b></td></tr>
					<tr><td>Total Slots=> <?php echo $mycount-1;?></td>
						<td>Not Marked=> <?php echo $NotMarkedCounter; // $NotMarkedCounter;?></td>
						<td>Early Presence=> <?php echo $EarlyCounter; //$EarlyCounter;?></td>
						<td>Late Presence=> <?php echo $LateCounter; //$LateCounter;?></td>
						<td>Absence=> <?php echo $AbsentCounter;?></td>
						<td>Rate=> <?php // echo ((strpos(strtolower($staffName), 'prof' ) !== false)? '#5000':'#1500');// echo 'NA';?></td>
						<td><!--Worth=> <?php //echo ((strpos(strtolower($staffName), 'prof' ) !== false)? 10000:($totalAttValue*750)); echo 'NA';?><br> -->EMR: Exam Malpractice Report Form</td>
						<td><b>Send EMR to: timtec@funaab.edu.ng</b>  </td>
					</tr>
					<tr> <td  colspan="8"><a href="<?php echo($link_Print); ?>">[Printable Version]</a></td></tr>
				<?php }
		    
		else{
				?>
				<tr>
				<td  colspan="8"><p><?php echo "No Records Match! or No slot Assigned yet. Reach out to TIMTEC Secretariat. Thanks ";?></td></tr>
				<?php
				}
				?></tbody> </table></div><?php	
			  }
		 
			 ?>
<!-- Comment this later   -->
 <p> <strong>NOTE:</strong> Lead Invigilators (on date(s) assigned/appointed above ONLY) can access and Download the Examination Malpratice Report(EMR) Form to administer malpratice cases where and when applicable. </p>
    <p> <strong>STUDENT EXAMINATION RULES – A Quick Reminder</strong></p>
<div>

<UL>

<li>There is no provision for special centre,  any clashes must be reported through students respective HODs to TIMTEC before exam 
<li>Mobile phone and face cap and face covering are not allowed in examination hall. Only current university ID card is valid to identify students for examination
<li>Lateness to exam halls or holding area and violation of examination rules would not be condoned. Students must not write at the back of your examination schedule
<li>Students are expected to always check the notice board for any change in exam schedule and final examination timetable. 
<li>Students who fail to adhere strictly to their exam schedule will not be allowed to sit for the examination
<li>If there are any clashes between e-exams and written examination, Students are expected to report to TIMTEC office for PRIORITY SLIP same day of the examination. </li>
<li> Encouraging Moral Dressing</li>
</UL></div> 

<p> For clarifications and enquiries please contact TIMTEC Secretariat or</p> 			    
                <?php echo $ContactLine;?>
                <p>Thanks.</p>
          </div>
   		</div>
<?php
include("footer.php");
?>