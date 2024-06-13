<?php
// Example usage
require_once("../dbcon/dbcon.php");
require_once("prinx_PDFclass.php");

$tableName = "timtec";
$outputFile = "adminuser.pdf";
$logoPath = "../Images/funaablogo.png"; // Replace with the actual path or URL to your logo image
$universityName = "Federal University of Agriculture";
$adminUsers = "Admin Users List";
$date = date("Y-m-d");
$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$topHeading = "$universityName\n$adminUsers";
$footer = "URL: $url -$date";

$pdfGenerator = new PDFGenerator($host, $user, $pwd, $database, $logoPath, $topHeading, $footer);
$pdfGenerator->generatePDF($tableName, $outputFile);

$pdf = $outputFile . ' has been generated. Please go to download';

// Download the PDF file
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $outputFile . '"');
readfile($outputFile);

// Clean up the generated PDF file
unlink($outputFile);

header("Location: site_admin.php?pdf=" . urlencode($pdf));
exit();
?>
