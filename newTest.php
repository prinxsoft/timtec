<?php

//$arraySize=$prd*$slot;
//$arraySize=$prd*$theslot;
function getPeriod($prd){
global $prdDty;
	switch ($prd){
		case 2:
		$prdDty = array(1 => "Morning(9am-12noon)", 2 => "Evening(2pm-5pm)");
		break;
		case 3:
		$prdDty = array(1 => "Morning(9am-12noon)", 2 => "Afternoon(12noon-3pm)", 3 => "Evening(3pm-6pm)");
		break;
		case 4:
		$prdDty = array(1=>'Morning(9am-11am)',2=>'Early Afternoon(11am-1pm)',3=>'Late Afternoon(2.30pm-4.30pm)',4=>'Evening(4.30pm-6.30pm)');
		break;	
	}
	return $prdDty;
}
//
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
}// end of generator function

//output result here!
$prd=3;
$theslot=5;
$arraySize=$prd*$theslot;
$arrayShow = array();
$mytestArray=getPeriod($prd);
$temp=periodGen($prd,$theslot,$mytestArray);
$thisMoment = "Data".date("YmdhisA").".csv";
echo($thisMoment);
for($counter=1;$counter<=$arraySize;$counter++){
$arrayShow[$counter]= $temp[$counter];
echo('<p>');
	echo "period".$counter." is ".$arrayShow[$counter];
	echo('</p>');
}
?>