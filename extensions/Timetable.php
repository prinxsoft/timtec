<form action="<?php echo($_SERVER['PHP_SELF'])?>" method="post" name="form1">
<input name="submit" type="submit" value="generate Invigilation Roaster">
</form><a href="javascript: window.printNow();">PrintOut-Roaster</a>
<?php
include("../conn.php");
//u can set parameters for daysOfexam, 
if(isset($_POST['submit']) )
{		$i = 1;
		$NoStaff=0;
		$startup=0;
		$thisMoment = "Data".date("YmdhisA").".csv";
		$fh = fopen($thisMoment,"a");
		global $staffCounter;
		$query= "select * from staff where staffCatId=1 and staffStatusId=1 and active=1 order by orderId ;";
		$result= mysqli_query($db, $query);	
		$staffCounter = mysqli_num_rows($result);
	for($dayIterate=1; $dayIterate<=15; $dayIterate++)
	{
	//echo('</p>'.'<h2>'.'DAY'.$dayIterate.'</h2>');
		$mysql1= "select epf.frequency, et.examTypeId, et.examTypeName from dayperiod dp JOIN examtype et on(dp.examTypeId=et.examTypeId) join examday ed on(ed.examDayId=dp.examDayId) join examperiodfreq epf on(epf.periodFreqId = dp.periodFreqId) where ed.examDayId='".$dayIterate."' ORDER BY et.examTypeId ";
		
		$result= mysqli_query($db, $mysql1);				
		$num_rows = mysqli_num_rows($result);
		while (list($frequency, $examTypeId, $examType) = mysqli_fetch_row($result))
		{
			$maxi= $frequency;
			$exam= $examTypeId;
			//echo('<br>'.'<h3>'.$examType.'</h3>');
			$query= "select h.hallName,h.hallCat, h.hallMainCat, h.hallCatTimtec, h.hallCatTimtecNew, h.hallmax, hfe.hasExam from hall h join examallocatehall eah on (h.hallId=eah.hallId) join hallforexam hfe on (h.hallId=hfe.hallId) where eah.examId='".$exam."' and hfe.hasExam>0 and hfe.examDayId='".$dayIterate."' ";
			$result1= mysqli_query($db, $query) or die(mysqli_error($db));;	
			while (list($hallname, $hallCat, $hallMainCat, $hallCatTimtec, $hallCatTimtecNew, $hallmax,$hasExam) = mysqli_fetch_row($result1))
			{
			//echo '<br>'.'<h3>'.$hallname.'</h3>';
			if($hasExam==3){ 
			$NoStaff= (int) $hallmax * $maxi;
			$arrayShow = array($NoStaff);
			$mytestArray=getPeriod($maxi,$hasExam);
			$maxiCounter= count($mytestArray);
			$temp=periodGen($maxiCounter,$hallmax,$mytestArray);
			}
			elseif($hasExam==2){
			//$maxi=$maxi/2;
			$NoStaff= (int) (($hallmax * $maxi)/2);
			$arrayShow = array($NoStaff);
			$mytestArray=getPeriod($maxi,$hasExam);
			$maxiCounter= count($mytestArray);
			$temp=periodGen($maxiCounter,$hallmax,$mytestArray);
			}
			elseif($hasExam==1){
			//$maxi=$maxi/2;
			$NoStaff= (int) (($hallmax * $maxi)/2);
			$arrayShow = array($NoStaff);
			$mytestArray=getPeriod($maxi,$hasExam);
			$maxiCounter= count($mytestArray);
			$temp=periodGen($maxiCounter,$hallmax,$mytestArray);
			}
			/*$NoStaff= (int) $hallmax * $maxi;
			$arrayShow = array($NoStaff);
			$mytestArray=getPeriod($maxi);
			$temp=periodGen($maxi,$hallmax,$mytestArray);
			*/
			$querystaff="select s.staffName,s.title, s.initials, s.staffSp, s.staffSex, d.deptCode from staff s JOIN department d on(s.staffDeptId=d.deptId) where s.staffCatId=1 and s.staffStatusId=1 and s.active=1 ORDER BY s.orderId LIMIT $startup,$NoStaff;";

			$result2= mysqli_query($db, $querystaff);
				//echo ('Staff Required here: '.$NoStaff);
				//echo ('<ul>');
				$inCount=1;
				while (list($staffName, $title, $initials, $staffSp, $staffSex, $deptCode)= mysqli_fetch_row($result2)) {
				$staffName = $title.' '.$initials.' '.$staffName; 
				$myrealGUID = $i.','.'DAY'.$dayIterate.','.$examType.','.$hallname.','.$hallCat.','.$hallMainCat.','.$hallCatTimtec.','.$hallCatTimtecNew.','.$NoStaff.','.$staffName.','.$staffSp.','.$staffSex.','.$deptCode.','.$inCount.','.trim($temp[$inCount]);
				//$myrealGUID = $i.','.'DAY'.$dayIterate.','.$examType.','.$hallname.','.$NoStaff.','.$staffName.','.$staffSp.','.$staffSex.','.$deptCode.','.$inCount.','.trim($temp[$inCount]);
				//echo('<li>'.$i.','.'DAY'.$dayIterate.','.$examType.','.$hallname.','.$NoStaff.', '.$staffName.', '.$staffSp.', '.$staffSex.', '.$deptCode.', '.$inCount.', '.$temp[$inCount].'</li>');
				fwrite($fh,$myrealGUID."\n");
				$inCount++;
				$i++;	
				}
				//echo ('</ul>'.'<br>');//value from line 14 query=284 as at 2020/21Second Sem. rerun 4 new semester
				if($i%284==0 && $inCount<$NoStaff){
				$startup=0;//($startup+$NoStaff)%fetchStaffCount();
				$NoStaff=$NoStaff-($inCount+1);
				}
				else{
				$startup=($startup+$NoStaff)%$staffCounter;
				}
				//echo ('</ul>'.'<br>');
				
			}
			//echo ('</p>');
			
		} 
		
	}
	fclose($fh);
	echo("file has been stored in CSV");
}

//Return pointer to original position
function getPeriod($prd,$hasexamcode){
global $prdDty;
if($hasexamcode==3){
	switch ($prd){
		case 2:
		$prdDty = array(1 => "Morning(9am-12noon)", 2 => "Afternoon(2pm-5pm)");
		break;
		case 3:
		$prdDty = array(1 => "Morning(9am-12noon)", 2 => "Afternoon(12noon-3pm)", 3 => "Evening(3pm-6pm)");
		break;
		case 4:
		$prdDty = array(1=>'Morning(9am-11am)',2=>'Early Afternoon(11am-1pm)',3=>'Late Afternoon(2.30pm-4.30pm)',4=>'Evening(4.30pm-6.30pm)');
		break;	
	}
	}
elseif($hasexamcode==1 && $prd==2){
$prdDty = array(1 => "Morning(9am-12noon)");
}
elseif ($hasexamcode==2 && $prd==2){
$prdDty = array(1 => "Afternoon(2pm-5pm)");
}

	return $prdDty;
}

function periodGen($period,$slot,$myarray){
global $prdResult;
$arrSize=$period*$slot;
$prdResult= array($arrSize);
$k=1;
for($p=1;$p<=$period;$p++){
	for($slt=1;$slt<=$slot;$slt++){
	$prdResult[$k]=$myarray[$p];
	$k++;

	}
}
return $prdResult;
}
   		

?>