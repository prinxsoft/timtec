<div class="col-sm-9">
<?php
//Site Name handler
$message = null;

if (isset($_POST['subsite'])) {
    if (empty($_POST['sitename'])) {
        $message = 'Site\'s or Group\'s  name cannot be empty';
    } else {
       //$message = $_POST['sitename'];
       $sname = $_POST["sitename"];
       $sname = strtoupper(stripslashes($sname));
       $sname = mysqli_real_escape_string($conn, $sname);
       $staffid = $_SESSION['spnumber'];
        
        $stmt = $conn->prepare("UPDATE site SET name = ?,update_by= ? WHERE site_id = 1");
        /* my database debugger
        if ($stmt==false){
            $message = mysqli_error($conn);
        }
        */
        $stmt->bind_param("ss", $sname,$staffid);
        
        if ($stmt->execute()) {
            // Log activities
            $log_state = 'Sets site/group name to ' . $sname;
            $stmt2 = $conn->prepare('INSERT INTO monitor (monitor_id, staff_id, activity, time_ref) VALUES (null, ?, ?, now())');
            $stmt2->bind_param("ss", $_SESSION['spnumber'], $log_state);
            $stmt2->execute();
            $stmt2->close();
            // Activities log closed

            $message = '<div id="siteupdate">Site\'s\Group\'s name; updated successfully to '.$sname.' '.' by '.$staffid.' <i class="fa-solid fa-check"></i></div>';
        } else {
            $message = 'Site name could not be updated. Please contact the developer.';
        }
        // Bind the parameter
        
    }
}
?>
<?php
//Site Session handler
$sess_mess= null;

if (isset($_POST['subsess'])) {
    if (empty($_POST['sitesession'])) {
        $sess_mess = 'Session name cannot be empty';
    } else {
       //$message = $_POST['sitename'];
       $s_sess = $_POST["sitesession"];
       $s_sess = strtoupper(stripslashes($s_sess));
       $s_sess = mysqli_real_escape_string($conn, $s_sess);
        
        $stmt = $conn->prepare("UPDATE site SET session = ?,update_by= ?  WHERE site_id = 1");

        // Bind the parameter
        $stmt->bind_param("ss", $s_sess,$_SESSION['spnumber']);
        
        if ($stmt->execute()) {
            // Log activities
            $log_state = 'Sets Session name to ' . $s_sess;
            $stmt2 = $conn->prepare('INSERT INTO monitor (monitor_id, staff_id, activity, time_ref) VALUES (null, ?, ?, now())');
            $stmt2->bind_param("ss", $_SESSION['spnumber'], $log_state);
            $stmt2->execute();
            $stmt2->close();
            // Activities log closed

            $sess_mess = '<div id="siteupdate">Site session has been updated successfully to '.$s_sess.' '.' by '.$_SESSION['spnumber']. ' <i class="fa-solid fa-check"></i></div>';
        } else {
            $sess_mess = 'Site name could not be updated. Please contact the developer.';
        }
    }
}
?>
<?php
//Semester's Handler
$sem_mess= null;

if (isset($_POST['subseme'])) {
    if (empty($_POST['sitesemester'])) {
        $sem_mess = 'Current Semester cannot be empty';
    } else {
       //$message = $_POST['sitename'];
       $s_seme = $_POST["sitesemester"];
       $s_seme = strtoupper(stripslashes($s_seme));
       $s_seme = mysqli_real_escape_string($conn, $s_seme);
        
        $stmt = $conn->prepare("UPDATE site SET current_semester = ?,update_by= ?  WHERE site_id = 1");

        // Bind the parameter
        $stmt->bind_param("ss", $s_seme,$_SESSION['spnumber']);
        
        if ($stmt->execute()) {
            // Log activities
            $log_state = 'Sets current semseter to ' . $s_seme;
            $stmt2 = $conn->prepare('INSERT INTO monitor (monitor_id, staff_id, activity, time_ref) VALUES (null, ?, ?, now())');
            $stmt2->bind_param("ss", $_SESSION['spnumber'], $log_state);
            $stmt2->execute();
            $stmt2->close();
            // Activities log closed

            $sem_mess = '<div id="siteupdate">Current semester has been updated successfully to '.$s_seme.' '.' by '.$_SESSION['spnumber']. ' <i class="fa-solid fa-check"></i></div>';
        } else {
            $sem_mess = 'Current semester could not be updated. Please contact the developer.';
        }
    }
}
?>

<?php
//Dead date complaints handler
$sess_comp= null;

if (isset($_POST['subcomp'])) {
    if (empty($_POST['sitecomp'])) {
        $sess_comp = 'Deadline for timetable complaints cannot be empty';
    } else {
        $s_comp = $_POST["sitecomp"];
        $s_comp = strtoupper(stripslashes($s_comp));
        $s_comp = mysqli_real_escape_string($conn, $s_comp);

        $stmt = $conn->prepare("UPDATE site SET dead_date_comp = ?, update_by = ?  WHERE site_id = 1");

        // Bind the parameters
        $stmt->bind_param("ss", $s_comp, $_SESSION['spnumber']);

        if ($stmt->execute()) {
            // Log activities
            $log_state = 'Sets dealine for timetable review to ' . $s_comp;
            $stmt2 = $conn->prepare('INSERT INTO monitor (monitor_id, staff_id, activity, time_ref) VALUES (null, ?, ?, now())');
            $stmt2->bind_param("ss", $_SESSION['spnumber'], $log_state);
            $stmt2->execute();
            $stmt2->close();
            // Activities log closed

            $sess_comp = '<div id="siteupdate">Deadline for timetable complaints has been updated successfully to '.$s_comp.' by '.$_SESSION['spnumber'].' <i class="fa-solid fa-check"></i></div>';
        } else {
            $sess_comp = 'Deadline for timetable complaints could not be updated. Please contact the developer.';
        }
    }
}

?>


<?php
//contact1 handler
$con_mess= null;

if (isset($_POST['subcon'])) {
    if (empty($_POST['contact1']) and empty($_POST['contact2'])) {
        $con_mess = 'TIMTEC\'s contact cannot be empty';
    } else {
       //$message = $_POST['sitename'];
       $con1 = $_POST["contact1"];
       $con2 = $_POST["contact2"];
        
        $stmt = $conn->prepare("UPDATE site SET contact1 = ?,contact2 = ?,update_by= ? WHERE site_id = 1");

        // Bind the parameter
        $stmt->bind_param("sss", $con1,$con2,$_SESSION['spnumber']);
        
        if ($stmt->execute()) {
            // Log activities
            $log_state = 'Sets 1st Contact to ' . $con1.' and 2nd contact to '.$con2;
            $stmt2 = $conn->prepare('INSERT INTO monitor (monitor_id, staff_id, activity, time_ref) VALUES (null, ?, ?, now())');
            $stmt2->bind_param("ss", $_SESSION['spnumber'], $log_state);
            $stmt2->execute();
            $stmt2->close();
            // Activities log closed

            $con_mess = '<div id="siteupdate">TIMTEC contacts; updated successfully to '.$con1.'/'.$con2.' by '.$_SESSION['spnumber']. ' <i class="fa-solid fa-check"></i></div>';
        } else {
            $con_mess = 'Site name could not be updated. Please contact the developer.';
        }
    }
}
?>
<?php
//institution's name handler
$sess_inst= null;

if (isset($_POST['subinst'])) {
    if (empty($_POST['instname'])) {
        $sess_inst = 'Institution\'s name cannot be empty';
    } else {
       //$message = $_POST['sitename'];
       $inst = $_POST["instname"];
       $inst = strtoupper($inst);
       $inst = mysqli_real_escape_string($conn,$inst);
        
        $stmt = $conn->prepare("UPDATE site SET institution = ?,update_by= ? WHERE site_id = 1");

        // Bind the parameter
        $stmt->bind_param("ss", $inst,$_SESSION['spnumber']);
        
        if ($stmt->execute()) {
            // Log activities
            $log_state = 'Sets Institution\'s name to ' . $inst;
            $stmt2 = $conn->prepare('INSERT INTO monitor (monitor_id, staff_id, activity, time_ref) VALUES (null, ?, ?, now())');
            $stmt2->bind_param("ss", $_SESSION['spnumber'], $log_state);
            $stmt2->execute();
            $stmt2->close();
            // Activities log closed


            $sess_inst = '<div id="siteupdate">Institution\'s name; updated successfully to '.$inst.' by '.$_SESSION['spnumber'].' <i class="fa-solid fa-check"></i></div>';
        } else {
            $sess_inst = 'Institution\'s name could not be updated. Please contact the developer.';
        }
    }
}
?>
<div id='tabs'>
                <ul>
                    <li><a href='#name'>Group/Committee</a></li>
                    <li><a href='#session'>Session</a></li>
                    <li><a href='#semester'>Current Semester</a></li>
                    <li><a href='#dline'>Complaints</a></li>
                    <li><a href='#inst'>Institution</a></li>
                    <li><a href='#contact'>Contact</a></li>
                  <!--  <li><a href='#dialogTab'>dialog</a></li> -->
                </ul>
                
                <div id='name'>
                    <?php 
                        if(isset($message)){
                            echo empty_val($message);
                        }
                    ?>
                    <?= textColor('Set Group Name')?>
                    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <div class="form-group">
                            <input type="text" name="sitename" id="sitename" class="form-control" placeholder="Enter site name">
                            <input class="mt-3" type="submit" name="subsite" value="Update Site">

                        </div>
                        
                    </form>
                    
                </div>

                <div id = "session">

                <?php 
                    if (isset($sess_mess)){
                        echo empty_val($sess_mess);
                    } 
                ?>
                    <?= textColor('Set Site Session')?>

                    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <div class="form-group">
                            <input type="text" name="sitesession" id="sitesession" class="form-control" placeholder="Enter academic session">
                            <input class="mt-3" type="submit" name="subsess" value="Update Session">
                        </div>
                        
                    </form>
                </div>

                <div id = "semester">

                <?php 
                    if (isset($sem_mess)){
                        echo empty_val($sem_mess);
                    } 
                ?>
                    <?= textColor('Set Current Semester')?>

                    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <div class="form-group">
                            <input type="text" name="sitesemester" id="sitesemester" class="form-control" placeholder="First Semester">
                            <input class="mt-3" type="submit" name="subseme" value="Update Semester">
                        </div>
                        
                    </form>
                </div>

                <div id = "dline">

                    <?php 
                        if (isset($sess_comp)){
                            echo empty_val($sess_comp);
                        } 
                    ?>
                    <?= textColor('Set Dealine (Complaints)')?>

                    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <div class="form-group">
                            <input type="text" name="sitecomp" id="sitecomp" class="form-control" placeholder="12 Midnight Sunday, January 22, 2023">
                            <input class="mt-3" type="submit" name="subcomp" value="Update Complaints Deadline">
                        </div>
                        
                    </form>
                </div>



                <div id = "inst">
                    <?php 
                        if (isset($sess_inst)){
                            echo empty_val($sess_inst); 
                        }
                    ?>
                    <?= textColor('Set Institution Name')?>

                    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <div class="form-group">
                            <input type="text" name="instname" id="instname" class="form-control" placeholder="Enter institutions name...">
                            <input class="mt-3" type="submit" name="subinst" value="Update Institution">
                        </div>
                        
                    </form>
                </div>

                <div id = "contact">
                    <?php 
                        if (isset($con_mess)){
                            echo empty_val($con_mess);
                        }
                    ?>
                    <?= textColor('Set Site TIMTEC Contact')?>

                    <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                        <div class="form-group">
                            <label>Contact 1:</label><input type="number" name="contact1" id="contact1" class="form-control" placeholder="Enter first contact">
                        </div>
                        <div class="form-group">
                            <label>Contact 2:</label><input type="number" name="contact2" id="contact2" class="form-control" placeholder="Enter first contact">
                        </div>
                            <input class="mt-3" type="submit" name="subcon" value="Update Contact">
                        </div>
                        
                    </form>

                </div>
                
                <!--<div id = "dialog" title = "my dialog">
                    <p>
                    The dialog class allows you to have a movable, sizable
                    customized dialog box consistent with the installed
                    page theme.
                    </p>
                </div>-->

            </div>
</div>
<?php
function textColor($value){
    return '<h5 class="text-success">'.$value.'</h5><br />';
}
function empty_val($value){
    return '<p><span class="text-danger">'.$value.'</span> <i class="fa-solid fa-circle-exclamation text-info"></i></p>';
}

?>