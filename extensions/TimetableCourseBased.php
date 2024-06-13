<form action="<?php echo($_SERVER['PHP_SELF'])?>" method="post" name="form1">
<input name="submit" type="submit" value="generate Invigilation Roaster">
</form><a href="javascript: window.printNow();">PrintOut-Roaster</a>
<?php
include_once("../conn.php");
//include_once("functions.php");	
//u can set parameters for daysOfexam,
//////////////////////////////////////////////THIS IS THE MOST RECENT AND UPTIGHTH VERSION  for Prof coord

//NOTE: isAssigned for coordinator Profs is 0 while the other profs get given after subtraction from list before stafflist upload

$minimum=null;
if(isset($_POST['submit']) )
{	
		$operation=9;  
		//change to suit operation  op3==>update,op2==>general, op1==>controls the general, op0==>courseCoordinators, op4 & op7==>unassigned Profs {min(0-1),max(1-2)}
		// 							op9==>assigned chiefobserverROle, op8==>Reset
		
		//insert coordinators first;
	if ($operation==0){
			//echo("<ul>");
			$i=0;
			
			$mysql_0 = "SELECT distinct CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, d.deptCode, c.CourseCode,  c.CocoordinatorSP, ce.CoursePeriod, ce.ExamDayId, ce.Hall, ce.HallId, ce.ExamType	FROM coordinator c, courseexamperiod ce, staff s, department d where s.staffDeptId=d.deptId and ce.CourseCode =c.CourseCode  and c.CocoordinatorSP=s.staffSp and s.active=1 and  c.Semester=2 and c.Session='2022/2023' ;";
			
			$result_0 = $db->query($mysql_0)or trigger_error($mysqli->error."[$mysql_0]");
			if($result_0) {
				while($row_d = $result_0->fetch_assoc())
				{	
					$CourseCode = $row_d['CourseCode'];
					$CocoordinatorSP = $row_d['CocoordinatorSP'];
					$rosterCoord=$CocoordinatorSP;
					$roasterStaffName = $row_d['fullname'];
					$roasterStaffDeptCode = $row_d['deptCode'];
					$CoursePeriod= $row_d['CoursePeriod'];
					$roasterPrd = $CoursePeriod;
					$ExamDayId = $row_d['ExamDayId'];
					$roasterhall = $row_d['Hall'];
					$ExamTypeId = $row_d['ExamType'];
					$roasterExamType= trim(getExamType($ExamTypeId));
					$roasterday= trim('DAY'.$ExamDayId);
							
					
					$mysql000= " select  staffRoasterId from staffroaster where staffSp IS NULL and day ='$roasterday' and ExamType='$roasterExamType' and Hall like '%$roasterhall%' and Period = '$roasterPrd' limit 0,1 ";
								//echo $mysql000;
								//exit();
								$result000 = $db->query($mysql000)or trigger_error($mysqli->error."[$mysql000]");	
								$num_rows000 = mysqli_num_rows($result000);
										
								if($num_rows000>0){
											
									while($row =$result000->fetch_assoc()){
												
										$staffRoasterId =$row['staffRoasterId'];
										$mysql10= "update staffroaster set staffSp='$rosterCoord', staffName='$roasterStaffName', staffDeptCode='$roasterStaffDeptCode' where staffRoasterId=$staffRoasterId ; ";
										
										$result = $db->query($mysql10)or trigger_error($mysqli->error."[$mysql10]");
										echo "<li> record : $i => staffRoasterId:$staffRoasterId successfully updated| for $rosterCoord ";
										if($result){
											echo "<li> record : $i => staffRoasterId:$staffRoasterId successfully updated|";
												$mysqlSlotUpd= " update staff set slot=slot+1, IsAssigned=1 where staffSp='$rosterCoord';";
												$result2= mysqli_query($db,$mysqlSlotUpd);
												if($result2){
														echo(" Update for $rosterCoord to slot staffSlot successful "."\n. </li>");
												}
											}
										}
								}
							}

													
						
					$i++;	
				}	

									
									
									
			}   
						   
		
		//insert coordinators first old version;
	elseif ($operation==15){
			//echo("<ul>");
			$i=0;
			$mysql_0 = "SELECT c.CourseCode, c.coordinatorSp,  c.IsCoordAvailable, c.CocoordinatorSP, c.Semester, c.Session, CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffName, d.deptCode FROM coordinator c, staff s, department d where s.staffDeptId=d.deptId and s.active=1 and s.staffSp=c.coordinatorSp  and c.Semester=2 and c.Session='2022/2023' ;";
			$result_0 = $db->query($mysql_0)or trigger_error($mysqli->error."[$mysql_0]");
			if($result_0) {
				while($row_d = $result_0->fetch_assoc())
				{	
					$CourseCode = $row_d['CourseCode'];
					$coordinatorSp = $row_d['coordinatorSp'];
					$IsCoordAvailable = $row_d['IsCoordAvailable'];
					$CocoordinatorSP = $row_d['CocoordinatorSP'];
					$Semester = $row_d['Semester'];
					$Session = $row_d['Session'];
					$roasterStaffName = $row_d['fullname'];
					$roasterStaffDeptCode = $row_d['deptCode'];
					$rosterCoord=($IsCoordAvailable==1)? $coordinatorSp:$CocoordinatorSP;

					//level 2 loop check when is course
					
					$mysql_1="SELECT  CoursePeriod, ExamDayId,  Semester, Session, Hall, HallId, ExamType FROM courseexamperiod where Semester=2 and Session='2022/2023' and CourseCode like '%$CourseCode%' limit 0,1;"; 
					
					//echo $mysql_1;
					//exit();
					$result_1 = $db->query($mysql_1)or trigger_error($mysqli->error."[$mysql_1]");
					if($result_1) {
						while($row_d1 = $result_1->fetch_assoc())
						{	
							$CoursePeriod= $row_d1['CoursePeriod'];
							$roasterPrd = trim(ucfirst($CoursePeriod));
							$ExamDayId = $row_d1['ExamDayId'];
							$roasterhall = $row_d1['Hall'];
							$HallId = $row_d1['HallId'];
							$ExamTypeId = $row_d1['ExamType'];
							$roasterExamType= getExamType($ExamTypeId);
							$roasterday= 'DAY'.$ExamDayId;
							
							$check_sql="select staffRoasterId from staffroaster where staffSp='$rosterCoord' and day='$roasterday' and ExamType='$roasterExamType' and Hall='$roasterhall' and Period='$roasterPrd'; ";
							$check_result = $db->query($check_sql)or trigger_error($mysqli->error."[$check_sql]");	
							$check_num_rows = mysqli_num_rows($check_result);
									
							if(!$check_num_rows>0){
										
								$mysql000= " select  staffRoasterId from staffroaster  where staffSp IS NULL and day='$roasterday' and ExamType='$roasterExamType' and Hall='$roasterhall' and Period='$roasterPrd' and  Incounter=1";
								//echo $mysql000;
								//exit();
								$result000 = $db->query($mysql000)or trigger_error($mysqli->error."[$mysql000]");	
								$num_rows000 = mysqli_num_rows($result000);
										
								if($num_rows000>0){
											
									while($row =$result000->fetch_assoc()){
												
										$staffRoasterId =$row['staffRoasterId'];
										$mysql10= "update staffroaster set staffSp='$rosterCoord', staffName='$roasterStaffName', staffDeptCode='$roasterStaffDeptCode' where staffRoasterId=$staffRoasterId ; ";
										$result = $db->query($mysql10)or trigger_error($mysqli->error."[$mysql10]");
										if($result){
											echo "<li> record : $i => staffRoasterId:$staffRoasterId successfully updated|";
											
											//$mysql000= " select staffSp, count(staffSp) AS staffSlot from staffroaster where LENGTH(staffSp)>1 group by staffSp  having staffSp='$rosterCoord' ;";
											
											//$result000 = $db->query($mysql000);
											//while($row1 =$result000->fetch_assoc())
											//{
											//	$staffSp=$row1['staffSp'];
											//	$staffSlot=$row1['staffSlot'];
												$mysqlSlotUpd= " update staff set slot=slot+1 where staffSp='$rosterCoord';";
												$result2= mysqli_query($db,$mysqlSlotUpd);
												
												//$mysqlslotUpd2 = "insert into rosterobserverstatus(staffroasterId, hasObserver) values($staffRoasterId,1);";
												//$result3= mysqli_query($db,$mysqlslotUpd2);
												if($result2){
														echo(" Update for $rosterCoord to slot staffSlot successful "."\n. </li>");
												}
											}
										}
								}
							}

													
						}
							
					}
					$i++;	
				}	

									
									
									
			}   
						   
				   
	
	}
	// apply this after you are through with bothe Auto and manual slot allocation | download roster from online apply this and reupload (on weekend)
	elseif ($operation==9){
			echo("<ul>");
			$i=0;
			$mysql_0 = "SELECT DISTINCT scheduleDate, examType,hall, period FROM `staffroaster` where Incounter=80;";
			$result_0 = $db->query($mysql_0)or trigger_error($mysqli->error."[$mysql_0]");
			if($result_0) {
				while($row_d = $result_0->fetch_assoc())
				{	
					//$roasterhalldaymaxId=$row_d['roasterhalldaymaxId'];
					$scheduleDate = $row_d['scheduleDate'];
					$examType = $row_d['examType'];
					$hall = $row_d['hall'];
					$period = $row_d['period'];
					
					//check for the given max rank
					$mysql_1="select st.staffRoasterId, st.staffSp, s.rank from staffroaster st, staff s where st.staffSp=s.staffSp and st.scheduleDate='$scheduleDate' and st.ExamType='$examType' and st.Hall='$hall' and st.Period='$period' order by s.rank DESC, s.staffSp ASC limit 0,1;"; 
					$result_1 = $db->query($mysql_1)or trigger_error($mysqli->error."[$mysql_1]");
					//echo($mysql_1);
					//exit();
					if($result_1) {
						while($row_d1 = $result_1->fetch_assoc())
						{	
							$staffRoasterId= $row_d1['staffRoasterId'];
							$staffSp = $row_d1['staffSp'];
							$rank = $row_d1['rank'];
							
							$mysql10= "update staffroaster set hasObserver=1 where staffRoasterId=$staffRoasterId ; ";
							$result = $db->query($mysql10)or trigger_error($mysqli->error."[$mysql10]");
							
							$mysql19 = "INSERT INTO rosterobserverstatus "." (staffRoasterId,hasObserver) "."VALUES "." ($staffRoasterId,1)";
							
							$resultNEW = $db->query($mysql19)or trigger_error($mysqli->error."[$mysql19]");
							
							if($result && $resultNEW){
								echo "<li> Updated record : $i => staffRoasterId:$staffRoasterId successfully updated| with rank:$rank for staff:$staffSp </li>";
							
							}
						}

													
					}
					$i++;		
				}
			}	

			echo("</ul>");			
	}
	elseif($operation==5){
			//Next OTHER DAY SHUFFLE OF ALLOTMENT //insert Prof invigilators next ;
			//check if there is still an unasigned slot.
				//echo("<ul>");
				
				$startup=0;
				//$minimum =0;
				for($dayIterate=1; $dayIterate<=15; $dayIterate++)
					{
							//$minimum = getMin();
							//$minimum=7;
							$n=30; // number of slot share open per day for prof wdt a slot
							// Get the Ids of the slots unassigned per round/ExamDay
							$Currentday='DAY'.$dayIterate;
							$mysql_0= "SELECT staffRoasterId from staffroaster where day='$Currentday' and staffSp is NULL LIMIT 0,$n ;";
							$result = $db->query($mysql_0)or trigger_error($mysqli->error."[$mysql_0]");		
							$num_rows_0 = mysqli_num_rows($result);
							$Schedule_array = array();
							$schduleCount=0;
							while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
							{ 
								$Schedule_array[$schduleCount]= $row['staffRoasterId'];
								$schduleCount++;
							}
							
							// Get the minimum slot per round --SELECT MIN(slot) AS minimum from staff where and slot<>0
							//$minimum = getMin();
							$maximum = 7;
							$minimum=5;
								//if day is not greater than 1 use  //removed and staffroaster.day='$Currentday'
								if($dayIterate=1){
									//for eachday select staff  from stafflist where staff in (select distinct staff in roaster who does not have invigilation on either present day or a day before and length(staff)>1
										//$Myquery= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and staffCatId=1 and s.active=1 and s.slot>=$minimum and s.slot<=$maximum and s.staffSp NOT IN(select distinct staffSp from staffroaster where LENGTH(staffroaster.staffSp)>1 and staffroaster.day='$Currentday') ORDER BY slot ASC  LIMIT 0,$num_rows_0;";
										$Myquery= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffName, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and staffCatId=1 and staffStatusId=1 and s.active=1 and (s.slot between $minimum and $maximum) and s.staffSp NOT IN(select distinct staffSp from staffroaster where staffroaster.staffSp is NOT NULL ) ORDER BY s.slot ASC  LIMIT 0,$num_rows_0;";
										
								}
								else{
									 $prev=$dayIterate-1;
									 $Previousday='DAY'.$prev;
									//querry=//for eachday select staff  from stafflist where staff in (select distinct staff in roaster who does not have invigilation on either present day or a day before and length(staff)>1 ///between $minimum and $maximum
									//$Myquery= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and staffCatId=1 and s.active=1 and s.slot>=$minimum and s.slot<$maximum and s.staffSp NOT IN(select distinct staffSp from staffroaster where LENGTH(staffroaster.staffSp)>1 and staffroaster.day in('$Currentday','$Previousday') )ORDER BY slot ASC LIMIT 0,$num_rows_0;";
									$Myquery= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffName, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and staffCatId=1 and staffStatusId=1 and s.active=1 and s.orderId<>0 and (s.slot between $minimum and $maximum) and s.staffSp NOT IN(select distinct staffSp from staffroaster where staffSp is not NULL and staffroaster.day in('$Currentday','$Previousday') )ORDER BY s.slot ASC LIMIT 0,$num_rows_0;";
								
								}
								$schdule=0;
								$result_Myquery = $db->query($Myquery)or trigger_error($mysqli->error."[$mysql_0]");;
								while($rowNew = mysqli_fetch_array($result_Myquery,MYSQLI_ASSOC))
									{
										$staffName= $rowNew['fullname'];
										$staffSp= $rowNew['staffSp'];
										$deptCode = $rowNew['deptCode'];
										$myUpdatesql= "update staffroaster set staffSp='$staffSp', staffName='$staffName', staffDeptCode='$deptCode' where day='$Currentday' and staffRoasterId= $Schedule_array[$schdule];";
										$result_myUpdatesql=  $db->query($myUpdatesql)or trigger_error($mysqli->error."[$myUpdatesql]");	
										
										$mysql000_1= " select staffSp, count(staffSp) AS staffSlot from staffroaster where staffSp is NOT NULL and staffSp='$staffSp' group by staffSp ;";
										//$result000= mysqli_query($db,$mysql000);	
										$result000_1 = $db->query($mysql000_1)or trigger_error($mysqli->error."[$mysql000_1]");
										while($row =mysqli_fetch_array($result000_1,MYSQLI_ASSOC))
										{
											$staffSp1= $row['staffSp'];
											$staffSlot = $row['staffSlot'];
											$mysqlSlotUpd= " update staff set slot=$staffSlot, IsAssigned=1 where staffSp='$staffSp1';";
											$result2= $db->query($mysqlSlotUpd);;
											if($result2){
													echo(" <li> Update for $staffSp slot successful "."\n. </li>");
											}
										}
										$schdule++;
								}	
							//}	

					}
					//set slot per coord  select staffSp, count(staffSp) AS staffSlot from staffroaster  where LENGTH(staffSp)>1 group by staffSp  order by count(staffSp) asc
							
								
			
	}
	elseif($operation==1){
			//Next OTHER DAY SHUFFLE OF ALLOTMENT //insert invigilators next ;
			//check if there is still an unasigned slot.
				//echo("<ul>");
				//increase this bound incrementally by 1 or place over a loop of 8/10 iterationss
				$bound=2;
				$Currentday='';
				//$minimum =0;
				for($dayIterate=1; $dayIterate<=15; $dayIterate++)
					{
							$Myquery= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffName, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and staffCatId=1 and staffStatusId=1 and s.active=1  and s.slot<=$bound and s.staffSp NOT IN(select distinct staffSp from staffroaster where staffSp is NOT NULL and staffroaster.day='$Currentday') ORDER BY s.orderId ASC ";
							$result_Myquery = $db->query($Myquery)or trigger_error($mysqli->error."[$mysql_0]");
							$staffcounter = mysqli_num_rows($result_Myquery);
							
							if($staffcounter>0){
								
								$Currentday='DAY'.$dayIterate;
								$mysql_0= "SELECT staffRoasterId from staffroaster where day='$Currentday' and staffSp IS NULL LIMIT 0, $staffcounter;";
								$result = $db->query($mysql_0)or trigger_error($mysqli->error."[$mysql_0]");		
								$num_rows_0 = mysqli_num_rows($result);
								$Schedule_array = array();
								$schduleCount=0;
								while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
								{ 
									$Schedule_array[$schduleCount]= $row['staffRoasterId'];
									$schduleCount++;
								}
							}
							$schdule=0;
					
							while($rowNew = mysqli_fetch_array($result_Myquery,MYSQLI_ASSOC))
								{
									if($schdule<$num_rows_0){
										$staffName= $rowNew['fullname'];
										$staffSp= $rowNew['staffSp'];
										$deptCode = $rowNew['deptCode'];
										$myUpdatesql= "update staffroaster set staffSp='$staffSp', staffName='$staffName', staffDeptCode='$deptCode' where day='$Currentday' and staffRoasterId= $Schedule_array[$schdule];";
										$result_myUpdatesql=  $db->query($myUpdatesql)or trigger_error($mysqli->error."[$myUpdatesql]");	
										
										if($result_myUpdatesql){
											$mysql000_1= " select staffSp, count(staffSp) AS staffSlot from staffroaster where staffSp IS NOT NULL and staffSp='$staffSp' group by staffSp ;";
											//$result000= mysqli_query($db,$mysql000);	
											$result000_1 = $db->query($mysql000_1)or trigger_error($mysqli->error."[$mysql000_1]");
											while($row =mysqli_fetch_array($result000_1,MYSQLI_ASSOC))
											{
												$staffSp1= $row['staffSp'];
												$staffSlot = $row['staffSlot'];
												$mysqlSlotUpd= " update staff set slot=slot+1 , IsAssigned=1 where staffSp='$staffSp1';";
												$result2= $db->query($mysqlSlotUpd);;
												if($result2){
														echo(" <li> Update for $staffSp slot successful "."\n. </li>");
												}
											}
										}
									}
									else{
										break;
									}
									$schdule++;	
								}	
								
					}
							//}	

	}
 //unassigned invigilators do this first THEN incrementally by 1 or looop over same way
	elseif($operation==2) 
	{
		//check while slot remain before running the next loop |  bound can be increased if slot remain
		///for($bound =0; $bound<9;$bound++){
					//check while slot remain before running the next loop
				
		///$CheckQuery ="SELECT * FROM staffroaster where staffSp is NULL";
		///$result_CheckQuery= $db->query($CheckQuery);
		///$checkCounter= mysqli_num_rows($result_CheckQuery);
			///if($checkCounter>0){
					
					$mysql_empty= "SELECT staffRoasterId from staffroaster where staffSp IS NULL ;";
							//$result_empty= mysqli_query($db,$mysql_empty);	
					$result_empty = $db->query($mysql_empty);
							//while($row =$result000_1->fetch_assoc())
					$num= mysqli_num_rows($result_empty);
					//do{
						if($num<>0){	
							if($num>=1)
							{
								$schduleCount=0;
								$Schedule_array2 = array();
								//while(list($staffRoasterId) = mysql_fetch_row($result_empty))
								//{
								while($row = mysqli_fetch_array($result_empty,MYSQLI_ASSOC)){
									$staffRoasterId =$row['staffRoasterId'];
									
									$Schedule_array2[$schduleCount]=$staffRoasterId;
									$schduleCount++;
								}
							}
								$n=sizeof($Schedule_array2);
								// echo "Status of DOne:$n";
								// exit;
						
							for($sch_itr=0; $sch_itr<$n; $sch_itr++)
							{	
									$bound=5; //the last max slot is the bound here
									//slect the day for the slot, check if each staff is not on inv on that same day staff assign staff to slot go to next slot
									$mysql_0= "SELECT day from staffroaster where staffRoasterId=$Schedule_array2[$sch_itr];";
									//$result_0= mysqli_query($db,$mysql_0);
									$result_0 = $db->query($mysql_0);
									while($row =$result_0->fetch_assoc())
									{
										$day =$row['day'];
										//$Myquery_new1= "select s.staffName, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and s.staffDeptId not in(43,44,45,46,47,49) and staffCatId=1 and s.active=1 and s.slot>=$minimum and staffSp NOT IN(select distinct staffSp from staffroaster where day='$day') order by staffId Limit 1;"; w
										//$Myquery_new1= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and s.staffCatId=1 and s.active=1 and s.slot>=$minimum and s.slot<$maximum and s.stafsfSps NOT IN(select distinct staffSp from staffroaster where day='$day') order by s.slot ASC Limit 0,1;";
										$Myquery_new1= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and s.staffCatId=1 and s.staffStatusId=1 and s.active=1 and s.orderId>0 and s.slot<=$bound and s.staffSp NOT IN(select distinct staffSp from staffroaster where staffSp IS NOT NULL and staffroaster.day='$day') order by s.orderId ASC Limit 0,1;";
										
										//$result_new1= mysqli_query($db,$Myquery_new1);
										$result_new1 = $db->query($Myquery_new1);
										$numbr= mysqli_num_rows($result_new1);
									  if($numbr>0){
										while($row2 =$result_new1->fetch_assoc())
										{
											$fullname=$row2['fullname'];
											$staffSp=$row2['staffSp'];
											$deptCode=$row2['deptCode'];
											$myUpdatesql_new= "update staffroaster set staffSp='$staffSp', staffName='$fullname', staffDeptCode='$deptCode' where staffRoasterId= $Schedule_array2[$sch_itr];";
											$result_myUpdatesql_new= mysqli_query($db,$myUpdatesql_new);	
											
											//$mysqlSlotUpd= " update staff set slot=slot+1 where staffSp='$staffSp';";
											//$result2 = mysql_query($mysqlSlotUpd);
											
											//set slot per coord  select staffSp, count(staffSp) AS staffSlot from staffroaster  where LENGTH(staffSp)>1 group by staffSp  order by count(staffSp) asc
											$mysql000= " select staffSp, count(staffSp) AS staffSlot from staffroaster where staffSp IS NOT NULL group by staffSp  having staffSp='$staffSp' ;";
											
											$result000 = $db->query($mysql000);
											while($row1 =$result000->fetch_assoc())
											{
												$staffSp=$row1['staffSp'];
												$staffSlot=$row1['staffSlot'];
												$mysqlSlotUpd= " update staff set slot=$staffSlot, IsAssigned=1 where staffSp='$staffSp';";
												$result2= mysqli_query($db,$mysqlSlotUpd);
												if($result2){
														echo(" <li> Update for $staffSp to slot $staffSlot successful "."\n. </li>");
												}
											}
										}
										}	
										else{break;}
									 } 
							}
						}
						else{echo(" <br/> All slots have been successfully taken "."\n. STOP!");}
					///}
					///else{break;}
				///}
	}
	//unassigned profs
	elseif ($operation==4){
		for($bound =0; $bound<1;$bound++){
			//uese bound 1 means assigne up to 2 max slot for prof start from 0-1
			//check if there are still unused slots complete process to finish allotment
					$mysql_empty= "SELECT staffRoasterId from staffroaster where staffSp IS NULL ;";
							//$result_empty= mysqli_query($db,$mysql_empty);	
					$result_empty = $db->query($mysql_empty);
							//while($row =$result000_1->fetch_assoc())
					$num= mysqli_num_rows($result_empty);
					//do{
							
							if($num>=1)
							{
								$schduleCount=0;
								$Schedule_array2 = array();
								//while(list($staffRoasterId) = mysql_fetch_row($result_empty))
								//{
								while($row = mysqli_fetch_array($result_empty,MYSQLI_ASSOC)){
									$staffRoasterId =$row['staffRoasterId'];
									
									$Schedule_array2[$schduleCount]=$staffRoasterId;
									$schduleCount++;
								}
							}
							//print_r($Schedule_array2);
							//exit();
								$n=sizeof($Schedule_array2);
								// echo "Status of DOne:$n";
								// exit;
								for($sch_itr=0; $sch_itr<$n; $sch_itr++)
								{	
									
									$mysql_0= "SELECT day from staffroaster where staffRoasterId=$Schedule_array2[$sch_itr];";
									//$result_0= mysqli_query($db,$mysql_0);
									$result_0 = $db->query($mysql_0);
									while($row =$result_0->fetch_assoc())
									{
										$day =$row['day'];		
										$Myquery_new1= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and s.staffCatId=2 and s.staffStatusId=1 and s.active=1 and Isprof=1 and s.slot=0 and s.staffSp NOT IN(select distinct staffSp from staffroaster where staffSp IS NOT NULL and staffroaster.day='$day') order by s.orderId ASC Limit 0,1;";
										
										//$result_new1= mysqli_query($db,$Myquery_new1);
										$result_new1 = $db->query($Myquery_new1);
										$numbr= mysqli_num_rows($result_new1);
									  if($numbr>0){
										while($row2 =$result_new1->fetch_assoc())
										{
											$fullname=$row2['fullname'];
											$staffSp=$row2['staffSp'];
											$deptCode=$row2['deptCode'];
											$myUpdatesql_new= "update staffroaster set staffSp='$staffSp', staffName='$fullname', staffDeptCode='$deptCode' where staffRoasterId= $Schedule_array2[$sch_itr];";
											$result_myUpdatesql_new= mysqli_query($db,$myUpdatesql_new);	
											
											//$mysqlSlotUpd= " update staff set slot=slot+1 where staffSp='$staffSp';";
											//$result2 = mysql_query($mysqlSlotUpd);
											
											//set slot per coord  select staffSp, count(staffSp) AS staffSlot from staffroaster  where LENGTH(staffSp)>1 group by staffSp  order by count(staffSp) asc
											$mysql000= " select staffSp, count(staffSp) AS staffSlot from staffroaster where staffSp IS NOT NULL group by staffSp  having staffSp='$staffSp' ;";
											
											$result000 = $db->query($mysql000);
											while($row1 =$result000->fetch_assoc())
											{
												$staffSp=$row1['staffSp'];
												$staffSlot=$row1['staffSlot'];
												$mysqlSlotUpd= " update staff set slot=$staffSlot, IsAssigned=1 where staffSp='$staffSp';";
												$result2= mysqli_query($db,$mysqlSlotUpd);
												if($result2){
														echo(" <li> Update for $staffSp to slot $staffSlot successful "."\n. </li>");
												}
											}
										}
										}	
										else{break;}
									 } 
								}
		}				
		
	}
	//old logic for unassigned prof 
	elseif($operation==7)
	{
			
				// run slot update
				//Next NON_CLASHING DAY SHUFFLE OF ALLOTMENT //insert invigilators next ;
				$done=false;
					//check if there are still unused slots complete process to finish allotment
					$mysql_empty= "SELECT staffRoasterId from staffroaster where staffSp='' order by staffRoasterId;";
							//$result_empty= mysqli_query($db,$mysql_empty);	
					$result_empty = $db->query($mysql_empty);
							//while($row =$result000_1->fetch_assoc())
					$num= mysqli_num_rows($result_empty);
						if($num>=1)
							{
								$schduleCount=0;
								$Schedule_array2 = array();
								while($row = mysqli_fetch_array($result_empty,MYSQLI_ASSOC)){
									$staffRoasterId =$row['staffRoasterId'];
									
									$Schedule_array2[$schduleCount]=$staffRoasterId;
									$schduleCount++;
								}
							}
							//print_r($Schedule_array2);
							//exit();
								$n=sizeof($Schedule_array2);
								// echo "Status of DOne:$n";
								// exit;
								for($sch_itr=0; $sch_itr<$n; $sch_itr++)
								{	//mark is 7
									$minimum = 0;
									$maximum=1;
									//slect the day for the slot, check if each staff is not on inv on that same day staff assign staff to slot go to next slot
									$mysql_0= "SELECT day from staffroaster where staffRoasterId=$Schedule_array2[$sch_itr];";
									//$result_0= mysqli_query($db,$mysql_0);
									$result_0 = $db->query($mysql_0);
									while($row =$result_0->fetch_assoc())
									{
										$day =$row['day'];
										//$Myquery_new1= "select s.staffName, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and s.staffDeptId not in(43,44,45,46,47,49) and staffCatId=1 and s.active=1 and s.slot>=$minimum and staffSp NOT IN(select distinct staffSp from staffroaster where day='$day') order by staffId Limit 1;";  //where day='$day'
										//select s.staffName AS fullname, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId and s.staffCatId=2 and staffStatusId=1 and orderId<>0 and s.active=1 and s.slot>=0 and s.slot<2 and s.staffSp NOT IN(select distinct staffSp from staffroaster where day IN('Day1')) order by s.slot, orderId ASC Limit 0,1;";
										$Myquery_new1= "select CONCAT(s.title,' ', s.initials,' ', s.staffName) AS fullname, s.staffSp, d.deptCode from staff s, department d where s.staffDeptId=d.deptId  and s.staffCatId=2 and staffStatusId=1  and s.active=1 and s.orderId>0 and s.slot=0 and s.staffSp NOT IN(select distinct staffSp from staffroaster where staffSp IS NOT NULL and day='$day') order by orderId ASC Limit 0,1;";
										
										//$result_new1= mysqli_query($db,$Myquery_new1);
										$result_new1 = $db->query($Myquery_new1);
										while($row2 =$result_new1->fetch_assoc())
										{
											$fullname=$row2['fullname'];
											$staffSp=$row2['staffSp'];
											$deptCode=$row2['deptCode'];
											$myUpdatesql_new= "update staffroaster set staffSp='$staffSp', staffName='$fullname', staffDeptCode='$deptCode' where staffRoasterId= $Schedule_array2[$sch_itr];";
											$result_myUpdatesql_new= mysqli_query($db,$myUpdatesql_new);	
											
											//$mysqlSlotUpd= " update staff set slot=slot+1 where staffSp='$staffSp';";
											//$result2 = mysql_query($mysqlSlotUpd);
											
											//set slot per coord  select staffSp, count(staffSp) AS staffSlot from staffroaster  where LENGTH(staffSp)>1 group by staffSp  order by count(staffSp) asc
											$mysql000= " select staffSp, count(staffSp) AS staffSlot from staffroaster where staffSp IS NOT NULL group by staffSp  having staffSp='$staffSp' ;";
											
											$result000 = $db->query($mysql000);
											while($row1 =$result000->fetch_assoc())
											{
												$staffSp=$row1['staffSp'];
												$staffSlot=$row1['staffSlot'];
												$mysqlSlotUpd= " update staff set slot=$staffSlot, IsAssigned=1 where staffSp='$staffSp';";
												$result2= mysqli_query($db,$mysqlSlotUpd);
												if($result2){
														echo(" <li> Update for $staffSp to slot $staffSlot successful "."\n. </li>");
												}
											}
										}
									 } 
								}
								//echo "Status of DOne: $done";
							//}while($num>0);
		
	}
	//update slots on staff table
	elseif($operation==3){
		
		$IsUpdated=false;
			$mysql000= " select staffSp, count(staffSp) AS staffSlot from staffroaster where staffSp is not NULL group by staffSp ;";
			$result000 = $db->query($mysql000);
			$count=0;
					while($row2 = mysqli_fetch_array($result000,MYSQLI_ASSOC))
					{		
									$staffSp =	$row2['staffSp'];
									$staffSlot = $row2['staffSlot'];
					
								$mysqlSlotUpd= " update staff set slot=$staffSlot, IsAssigned=1 where staffSp='$staffSp';";
								$result2= $db->query($mysqlSlotUpd);
								$count++;
					}
					if($count>1){
						$IsUpdated=true;
					}
			echo "updated  $count records ";
	}
	//reset all to empty
	elseif($operation==8){
			$mysqlSlotUpd= "update staffroaster set staffSp=NULL, staffName=NULL, staffDeptCode=NULL ;";
			$result2= $db->query($mysqlSlotUpd);
			if($result2){
				$mysqlSlotUpd2= "update staff set slot=0, IsAssigned=0;";
				$result2= $db->query($mysqlSlotUpd2);
			}
			echo "reset records successfully!";
	}
}
		
	//helper functions\
function getExamType($roasterExmTypeId){
	if($roasterExmTypeId==1) {
		return "WRITTEN EXAM";
	}
	else  return "e-EXAM" ;
}
		
?>