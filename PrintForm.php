<?php 

$today = date("F j, Y");
$today= (string)$today;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Application Form</title>
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:1068px;
	height:197px;
	z-index:1;
	left: 16px;
}
body {
	margin-top: 50px;
}
h2{
	letter-spacing:2px;
	font-family:Verdana, Geneva, sans-serif;
	color:#930;
}
a:link {
	color: #930;
}

-->
</style>
<script type="text/javascript" language="javascript1.5">
function printNow()
	{
	window.print() ;
	}
</script>
<?php 
/*
	function getExamNoID($myexamPin)
	{
	include("dbconnect.php");	
	if ($db_found)
	{
	$selectDisID=" Select Std_Id from studentrecords where Pin_Code='".$myexamPin."' ";
	$resultID = mysql_query($selectDisID);
	$numb_rows=mysql_num_rows($resultID);
			if ($numb_rows>0)
   			 {
			while ($db_field = mysql_fetch_assoc($resultID))
				{
				
				$ID = $db_field['Std_Id'];
				$captID=returnExamNumb($ID);
				echo($captID);
				}
			}	
		mysql_close($db_handle);	
	}
}

	function getVenueID($myPin)
	{
	include("dbconnect.php");	
	if ($db_found)
	{
	$selectDisID=" Select Std_Id from studentrecords where Pin_Code='".$myPin."' ";
	$resultID = mysql_query($selectDisID);
	$numb_rows=mysql_num_rows($resultID);
			if ($numb_rows>0)
   			 {
			while ($db_field = mysql_fetch_assoc($resultID))
				{
				
				$ID = $db_field['Std_Id'];
				$captID=VenueAllocator($ID);
				echo($captID);
				}
			}	
		mysql_close($db_handle);	
	}
}

	function getBatchID($batchPin)
	{
	include("dbconnect.php");	
	if ($db_found)
	{
	$selectDisID=" Select Std_Id from studentrecords where Pin_Code='".$batchPin."' ";
	$resultID = mysql_query($selectDisID);
	$numb_rows=mysql_num_rows($resultID);
			if ($numb_rows>0)
   			 {
			while ($db_field = mysql_fetch_assoc($resultID))
				{
				
				$ID = $db_field['Std_Id'];
				$captID=BatchAllocator($ID);
				echo($captID);
				}
			}	
		mysql_close($db_handle);	
	}
}

	function getReceiptID($batchPin)
	{
	include("dbconnect.php");	
	if ($db_found)
	{
	$selectDisID=" Select Std_Id from studentrecords where Pin_Code='".$batchPin."' ";
	$resultID = mysql_query($selectDisID);
	$numb_rows=mysql_num_rows($resultID);
			if ($numb_rows>0)
   			 {
			while ($db_field = mysql_fetch_assoc($resultID))
				{
				
				$ID = $db_field['Std_Id'];
				$captID=receiptID($ID);
				echo($captID);
				}
			}	
		mysql_close($db_handle);	
	}
}
*/
?>
</head>

<body onload="printNow()">
<table width="967" height="936" border="1" bordercolor="#006600" align="center" >
      <tr>
        <td width="966" height="101" bgcolor="#FFFFFF" align="center" valign="top"><img src="../Images/gif/unaabplainBanner.gif" width="965" height="101" alt="funaab" /></td>
      </tr>
      <tr   border="1">
        <td height="27" align="right"  background="../Images/headerbanner.jpg"><font color="#FFFFFF"><b>
		<?php 
		echo("Registration Date: ". $today);
		?></b></font></td>
      </tr>
      <tr  border="1" bgcolor="#FFFFFF">
        <td height="738"  background="../Images/unaab_bglogo.jpg"><table align="center" width="687" height="50" background=""><tr>
          <td width="679" align="center"><h2> Examination Invigilation Roaster<br/>2020/2021 Session (Second Semester) <a href="javascript: window.printNow();"><br/>Print - Out
</a></h2></td></tr></table><table align="center" width="860" height="50"><tr>
          <td width="860" align="left" style=""><br /><strong>e-Exam Training 2012 is an  intensive 3-days, hands-on training for Post-UTME candidates who are aspiring  for admission into any of Nigeria’s University and concerned with having to sit  for an e-exam.<p>
              During the training, you will be  familiar with the keyboard and mouse and learn how to proficiently navigate  your way through a Computer-Based Test popularly called e-exams. A Post-UTME  scenario will be simulated on the third day to further prepare you for the  D-day. At the end of this training, your apprehension would have become  history.</p>
          </strong></td></tr><tr>
          <td width="860" align="left" valign="top"><h4 style="font-stretch:extra-expanded; color:#930" >TIME TABLE</h4>
            <p><strong>Day 1: 17th May </strong>(9:15am  – 1:30pm): Computer Basics, e-Exam Basics and Hands-on exercises<br />
              <strong>Day 2: 18th July </strong>(9:15am  – 12pm): Simulated e-examination and  review<br />
            </p>
<Strong>This slip admits you to the Simulated e-Exam </strong>
           </td></tr></table><table width="854" height="392" align="center"> <tr><td width="846" align="left" style="HEIGHT: 30px"><hr /> &nbsp;&nbsp;<label>PIN NUMBER/CODE:&nbsp;&nbsp; </label></td>
			</tr><tr>
			  <td width="846" align="left" style="HEIGHT: 30px">&nbsp;&nbsp;<label>RECEIPT  NUMBER:&nbsp;&nbsp; </label></td>
			</tr><tr><td width="846" align="left" style=" HEIGHT: 30px" valign="middle"> &nbsp;&nbsp;<label>EXAMINATION NUMBER:&nbsp;</label> 
			<b>&nbsp;&nbsp; ET12/</b></td>
			</tr><tr><td width="846" align="left" style=" HEIGHT: 30px"> &nbsp;&nbsp;<label>FULL NAME:&nbsp;</label><b>&nbsp;&nbsp;  </b> </td>
			</tr>
            <tr>
              <td width="846" align="left" style=" HEIGHT: 30px"> &nbsp;&nbsp;EXAMINATION
                TIME
                <label>:&nbsp;</label> 
                9:45 AM</td>
			</tr><tr><td width="846" align="left" style=" HEIGHT: 30px"> &nbsp;&nbsp;<label>VENUE:&nbsp;</label> <b>&nbsp;&nbsp; </b></td>
			</tr><tr>
              <td width="846" align="left" style=" HEIGHT: 30px"> &nbsp;&nbsp;BATCH:&nbsp;&nbsp;</td>
			</tr>
            <tr>
              <td width="846" align="left" style=" HEIGHT: 3px">&nbsp;<i>Come with this Slip on or before 18th July 2012 to ICT Resource Center. Registration is on a first come first serve basis<br />
For further enquires please call: 08034096863.</i></td>
			</tr>
            <tr>
              <td width="846" align="left" style=" HEIGHT: 30px" valign="top"><HR />
                <i><strong>For Official Use </strong>(Submit this detarchable section to the ICTREC Staffs or Directorate)</i><br/>
                ------------------------------------------------------------------------------------------------------------------------------------<br />
              &nbsp;&nbsp;FULL NAME: <b></b></td>
			</tr>
<tr><td height="39"><table width="833" height="34"><tr><td width="347"><span style="HEIGHT: 30px">&nbsp;
  <label>PIN:&nbsp;&nbsp;<b> </b></label>
</span></td>
  <td width="290">JAMB  NO:&nbsp;&nbsp;<b></b> </td><td width="180"><span style=" HEIGHT: 30px">BATCH:&nbsp;&nbsp;</span></td></tr><tr>
    <td> <label>&nbsp;VENUE:  <b><font size="-1"></font></b></label></td>
    <td><span style=" HEIGHT: 30px">EXAM NO:</span><b> ET12/</b></td>
    <td>TIME: <b>To be Assigned</b></td></tr></table></td></tr>

</table></td>
      </tr>
     
      <table><tr><td> </td><td> </td><td> </td></tr><tr><td> </td><td> </td><td> </td></tr></table>
      <tr  height="40" border="1" >
        <td height="54"><font  color="#00CC00" align="center">Powered by  ICTREC, Federal University of Agriculture, Abeokuta (FUNAAB). 
          ©2012 All rights reserved.</font></td>
      </tr>
    </table>
