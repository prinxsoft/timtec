<?php
error_reporting(E_ALL);
$conn = mysqli_connect("localhost", "root", "", "timtec_roaster");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Retrieve the staffId sent via AJAX
$data = json_decode(file_get_contents('php://input'), true);
$staffId = $_POST['staffId'];

// Delete the row from the database
$sql = "DELETE FROM timtec WHERE staff_id = '$staffId'";

if ($conn->query($sql) === TRUE) {
  // Deletion successful
  $response = array('status' => 'success', 'message' => 'Row deleted successfully');
} else {
  // Error occurred
  $response = array('status' => 'error', 'message' => 'Error deleting row: ' . $conn->error);
}

$conn->close();

// Set the proper content type for JSON response
header('Content-Type: application/json');

// Send the JSON response back to the client
echo json_encode($response);
exit();
?>