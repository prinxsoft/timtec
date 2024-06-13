<?php
ob_start();

//include("conn.php");
//include_once("functions.php");
include_once('dbcon/dbcon.php');

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
   			<a href="#"><h2 class="title">Head of Departments' Page </h2></a>
            <hr />
   			<p>TIMTEC welcomes all Members of Staff into the <?= $name['session']; ?> Academic Session and as well appreciate you for your regular support towards timetabling and examination processes.</p>
   			
			<p>However, It is no longer news, that both students and Lecturers shall experience innovative and IT driven methods of teaching and learning as a 'new normal', whereby a hybrid design of Teaching and Learning shall be explored - some Virtual (On Google Classroom) and others Physical. <br/> This is in line with the decision of management to have both students and members of the university community strictly observe and comply with the COVID-19 safety protocols as directed by the Presidential Task Force (PTF) on COVID-19.<br/>
			
			</p>
			<p>Following the resumption to academic duty, HODs are hereby enjoined to download and peruse these following documents for comments, reactions and corrections to the First semester <?= $name['session']; ?> academic session lecture timetable and other documents given below;</p>
			
			<ul>
			    <li><a href="mgt_doc/LETTER_TO_HODs_ON_LECTURE_TIMETABLE_20192020.pdf"> Download:</a> Letter to HODs on <?= $name['session']; ?> Sorted Lecturer Timetable  </li>
			     
			    <li><a href="mgt_doc/LECTURE_TIME_TABLE_20192020_SORTED_FINAL_YEAR_CLASSES.pdf"> Download:</a> Final Copy of <?= $name['session']; ?> Sorted Lecturer Timetable for Final Year Classes </li>
			    
			    <li><a href="mgt_doc/LECTURE_TIME_TABLE_20192020_SORTED_NEW_NORMAL.pdf">  Download:</a> Final Copy of <?= $name['session']; ?> Sorted Lecturer Timetable for Other Classes in compliance with the 'New Normal'</li>
			    
			    <li><a href="mgt_doc/Virtual_Teaching_Training_for_Academic_Staff.pdf">  Download:</a> Invitation to the Virtual Teaching Training for Academic Staff </li>
			   
			</ul>
		<p>	
			However, The First Copy of the <?= $name['session']; ?> <?= $semester['current_semester'] ?> Examination is <strong>OUT</strong>. TIMTEC awaits reactions and comments to fasttrack the release of the Final Exams Timetable. Listed below are the documents for the two Exam types - Written and Electronic;</p>
			<ul>
				<li><a href="mgt_doc/2023_Exam_timetable_draft.pdf"> Download:</a> Edited DRAFT Copy of Written Exams Timetable  </li>
			    
			    <li><a href="mgt_doc/2023_eExam_timetable_draft.pdf"> Download:</a> DRAFT Copy of E-Exams Timetable</li>    
			</ul>
			
			            
	<?php
		/*
		$sql_HOD = " SELECT deptCode,name FROM department, hod where deptId=departmentId and spNumber='$staffNmb';" ;
		$result_HOD=mysqli_query($db,$sql_HOD);
		if(mysqli_num_rows($result_HOD) == 1){ 
					while($row = mysqli_fetch_array($result_HOD,MYSQLI_ASSOC)){
						$Dept = $row['deptCode'] ;
						$hod = $row['name'] ;
					}
		}
		
		$hodalloc = "SELECT staff, staffSp, staffDeptCode, InvDate, ExamType, Hall, Period FROM staffroaster where staffDeptCode='$Dept' order by InvDate,Period;" ;
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
					$staff = $row['staff'] ;
					$staffSp = $row['staffSp'] ;
					$staffDeptCode = $row['staffDeptCode'] ;
					$InvDate = $row['InvDate'] ;
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
						$link="../Print.php?";
						?>
					<tr> <td  colspan="8"><a href="<?php echo $link;?>">[Printable Version]</a></td></tr>
				<?php }
				else{
				?>
				<tr>
				<td  colspan="8"><p><?php echo "No Records Match! ";?></td></tr>
				<?php
				}
				?></tbody> </table></div><?php	
			  }
		*/	  
			 ?>
			Please, revert ASAP. Thanks.</p>

		<p>	LATEST NEWS <hr/>
		The Invigilation Roster for <?= $name['session']; ?> <?= $semester['current_semester'] ?> Examination is <strong>OUT</strong>. Members of Staff are enjoined to view, print or take note of these schedules for proper attendance and effective Examination invigilation process;</p>
			    
                <?php echo "$ContactLine";?>
                <p>Thanks.</p>
          </div>
   		</div>
<?php
include("footer.php");
?>