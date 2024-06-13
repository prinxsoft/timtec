<?php
error_reporting(E_ALL);
require_once('dbcon/dbcon.php');

// Retrieve the data sent via AJAX
$data = json_decode(file_get_contents('php://input'), true);
$rowId = $data['rowId'];
$staffId = $data['staffId'];
$offEmail = $data['offEmail'];

// Prepare the update query and execute it
$sql = "UPDATE timtec SET staff_id = '$staffId', off_email = '$offEmail' WHERE tim_id = $rowId";

if ($conn->query($sql) === TRUE) {
  // Update successful
  //$redirectURL = 'admin_users.php?message=' . urlencode(json_encode($response));
  $response = array('status' => 'success', 'message' => $staffId.' and row, updated successfully');
  //header('Location: ' . $redirectURL);
    //exit();
} else {
  // Update failed
  $response = array('status' => 'error', 'message' => 'Error updating row: ' . $conn->error);
}

// Send the JSON response back to the client
echo json_encode($response);
?>
