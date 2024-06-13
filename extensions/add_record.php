<?php
session_start();
$add_mess= null;
require_once('../dbcon/dbcon.php');

if (isset($_POST['subadmin'])) {
    if (empty($_POST['email']) and empty($_POST['staffid'])) {
        $add_mess = 'TIMTEC\'s contact cannot be empty';
    }else{
        //search for existing staff id
        $staffid = validator($_POST["staffid"]);
        $stmt = $conn->prepare('SELECT COUNT(*) FROM timtec WHERE staff_id = ?');
        $stmt->bind_param("s", $staffid);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            //record exists
            $add_mess = '<span id="siteupdate">Staff ID already exists in the database</span>';
            header("location: site_admin.php?mess=$add_mess");
        }else{
            $email = strtolower(validator($_POST["email"]));
            //new record
            $super_admin = $_POST['super_admin'];
            $sql = 'INSERT INTO timtec (tim_id, staff_id, off_email, super_admin, created_by, date_created) VALUES (null, "'.$staffid.'", "'.$email.'","'.$super_admin.'", "'.$_SESSION["spnumber"].'", now())';
            if ($conn->query($sql)===true){
                $add_mess = 'New user with Staff ID '. $staffid. ', added successfully';
            header("location: site_admin.php?mess=$add_mess");
            }else{
                $add_mess = 'record failed '.$conn->error;
                header("location: site_admin.php?mess=$add_mess");
            }
            //$stm->bind_param("sss", $staffid, $email, $_SESSION["spnumber"]);
            
            /*if ($stmt->execute()){
                $add_mess = 'A admin staff record has been added successfully';
                echo $add_mess;
               }*/
       
        }
    }

}else{
    //the button is not clicked
}
$conn->close();
function textColor($value){
    return '<h5 class="text-success">'.$value.'</h5><br />';
}
function empty_val($value){
    return '<p><span class="text-danger">'.$value.'</span> <i class="fa-solid fa-circle-exclamation text-info"></i></p>';
}
function validator($value){
    include("../dbcon/dbcon.php");
$value = stripslashes($value);
$value = mysqli_real_escape_string($conn,$value);
$value = preg_replace('/\s+/', '', $value);
$value = strtoupper($value);
return $value;
}

?>