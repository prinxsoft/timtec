<?php
include("header.php");
include("conn.php");

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
   			<a href="#"><h2 class="title">Chief Invigilator's Page </h2></a>
            <hr />
   			<p>The invigilation duty roaster for this Semester Examination is out. Chief Invigilators are hereby advised to check here for their invigilation schedules.</p>
            
		<?php
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
					<?php
					include("pagination.php");
					?>
					</td>
					</tr>
					</tfoot>
				<tbody>
				<?php
				
				if(mysqli_num_rows($result) >= 1)
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
						$link="../ChiefAttendance.php?";
						$link_Print="../Print.php?";
						?>
					<tr><td><a href="<?php echo $link;?>"> View Details</a></td> <td  colspan="6"><a href="<?php echo $link_Print;?>">[Printable Version]</a></td></tr>
				<?php }
				else{
				?>
				<tr>
				<td  colspan="7"><p><?php echo "No Records Match! ";?></td></tr>
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