<?php
// Get the contact number from the query string
$contactNumber = $_GET['phone'];

// Redirect to the WhatsApp API with the contact number
header("Location: https://api.whatsapp.com/send?phone=$contactNumber");
exit;
?>
